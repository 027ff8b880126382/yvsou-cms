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

class AutoUpdaterService
{
    protected string $repo;

    public function __construct()
    {
        $this->repo = config('version.github_repo'); // ✅ Now works!
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
        $latest = $release['tag_name'];
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $current = $composer['version'] ?? 'unknown';
        logger($release);
        logger($current);
        if ($latest && version_compare($current, $latest, '<')) {
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
        if (!$outdated['outdated'])
            return null;
        $zipUrl = $release['zipball_url'];
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

    public function backupCurrent(): ?string
    {
        $backupName = 'backup-' . date('YmdHis') . '.zip';
        $backupPath = storage_path("app/{$backupName}");

        $exclude = "--exclude=vendor --exclude=storage --exclude=.env";

        $command = "cd " . base_path() . " && zip -r {$backupPath} . {$exclude}";

        $result = null;
        $output = null;

        exec($command, $output, $result);

        return $result === 0 ? $backupPath : null;
    }

    public function applyUpdate(string $zipPath): bool
    {
        $extractPath = base_path('update-temp');

        if (!File::exists($extractPath)) {
            File::makeDirectory($extractPath, 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();

            // Merge extracted files with current app
            $this->recursiveCopy($extractPath, base_path());

            // Clean up
            File::deleteDirectory($extractPath);

            return true;
        }

        return false;
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
