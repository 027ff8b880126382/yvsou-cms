<?php
/**
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-07-02
* License: Dual Licensed – GPLv3 or Commercial
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* As an alternative to GPLv3, commercial licensing is available for organizations
* or individuals requiring proprietary usage, private modifications, or support.
*
* Contact: yvsoucom@gmail.com
* GPL License: https://www.gnu.org/licenses/gpl-3.0.html
*/

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use SebastianBergmann\Type\TrueType;
use Illuminate\Support\Facades\Log;


class AutoUpdaterService
{
    protected string $repo;
    protected string $app_version;

    public function __construct()
    {
        $this->repo = config('version.github_repo');
        $this->app_version = config('version.app_version');

    }
    public function checkLatestVersion(): ?array
    {
        $response = Http::get("https://api.github.com/repos/{$this->repo}/releases/latest");

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    public function isOutdated()
    {
        $release = $this->checkLatestVersion();
        logger(" release verion");

        $latest = $release['tag_name'];
        logger($latest);
        $current = $this->app_version;

        logger(" curent verion");
        logger($current);
        Log::debug('Current version: [' . $current . ']');
        Log::debug('Latest version: [' . $latest . ']');
        Log::debug('Compare: ' . (version_compare($current, $latest, '<') ? 'true' : 'false'));

        if ($latest && version_compare($current, $latest, '<')) {
            logger($latest);
            return [
                'outdated' => true,
                'latest' => $latest,
                'current' => $current,
            ];
        }

        return [
            'outdated' => false,
            'latest' => $latest,
            'current' => $current,
        ];
    }

    public function downloadLatestZip(): ?string
    {
        $release = $this->checkLatestVersion();
        if (!$release) {
            return null;
        }

        $outdated = $this->isOutdated();
        if (!$outdated['outdated']) {
            return null;
        }

        // ✅ Find the specific asset
        $asset = collect($release['assets'] ?? [])
            ->firstWhere('name', 'installvendor-' . $release['tag_name'] . '.zip');

        if (!$asset) {
            return null; // Asset not found
        }

        $zipUrl = $asset['browser_download_url']; // This is the real download link
        $fileName = 'update-' . $release['tag_name'] . '.zip';

        $zipContent = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
        ])->get($zipUrl);

        if ($zipContent->failed()) {
            return null;
        }

        Storage::disk('local')->put($fileName, $zipContent->body());

        return storage_path("app/{$fileName}");
    }


    public function backupCurrentCopy(): ?string
    {
        $backupDirName = 'backup-' . date('YmdHis');
        $backupPath = storage_path("app/backups/{$backupDirName}");

        // Create the backup directory
        File::makeDirectory($backupPath, 0755, true);

        $sourcePath = base_path();

        // Exclude these folders or files if needed
        $exclude = ['storage', '.env', 'node_modules', '.git'];

        $this->recursiveCopyWithExclude($sourcePath, $backupPath, $exclude);

        Log::info("Backup copied to: {$backupPath}");

        return $backupPath;
    }

    protected function recursiveCopyWithExclude($src, $dst, $exclude = [])
    {
        $dir = opendir($src);
        @mkdir($dst, 0755, true);

        while (false !== ($file = readdir($dir))) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (in_array($file, $exclude)) {
                continue;
            }

            $srcPath = "{$src}/{$file}";
            $dstPath = "{$dst}/{$file}";

            if (is_dir($srcPath)) {
                $this->recursiveCopyWithExclude($srcPath, $dstPath, $exclude);
            } else {
                copy($srcPath, $dstPath);
            }
        }

        closedir($dir);
    }

    public function extractZip(string $zipPath): ?string
    {
        $extractPath = base_path('update-temp');

        if (File::exists($extractPath)) {
            File::deleteDirectory($extractPath);
        }

        File::makeDirectory($extractPath, 0755, true);

        $zip = new \ZipArchive;
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();

            Log::info("Extracted ZIP to {$extractPath}");
            return $extractPath;
        }

        Log::error("Failed to open ZIP: {$zipPath}");
        return null;
    }

    public function overwriteWithExtract(string $extractPath): bool
    {
        $this->recursiveCopy($extractPath, base_path());
        File::deleteDirectory($extractPath);

        Log::info("Overwrite complete.");
        return true;
    }


    public function runPostUpdate(): void
    {
        // exec('composer install --no-dev --optimize-autoloader');
        try {
            \Artisan::call('config:cache');
            \Artisan::call('route:cache');
            \Artisan::call('view:cache');

            Log::info("Post-update complete.");
        } catch (\Exception $e) {
            Log::error("❌ Post-update failed: " . $e->getMessage());
        }

    }

    public function applyUpdate(): bool
    {

        $zipPath = $this->downloadLatestZip();
        if (!$zipPath) {
            return false;
        }

        $this->backupCurrentCopy();

        $extractPath = $this->extractZip($zipPath);
        if (!$extractPath) {
            return false;
        }

        $this->overwriteWithExtract($extractPath);

        $this->runPostUpdate();

        return true;


    }

    protected function recursiveCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst, 0755, true);

        while (false !== ($file = readdir($dir))) {
            if (($file !== '.') && ($file !== '..')) {
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;

                if (is_dir($srcPath)) {
                    $this->recursiveCopy($srcPath, $dstPath);
                } else {
                    copy($srcPath, $dstPath);
                }
            }
        }
        closedir($dir);
    }
}
