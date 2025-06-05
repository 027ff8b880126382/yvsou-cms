<?php
/**
 * © 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo   All rights reserved.
 * Author: Lican Huang
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
use App\Models\PostReversion;
class ReversionService
{

  public  function applyHtmlDiff(string $baseContent, array $diffBlocks): string
    {
        $patchedLines = [];
        $baseLines = explode("\n", $baseContent);
        $lineIndex = 0;


        if (!isset($diffBlocks[0]) || !is_array($diffBlocks[0])) {
            throw new \Exception('Invalid diff structure.');
        }

        foreach ($diffBlocks[0] as $block) {

            if (
                isset($block['old'], $block['old']['offset'], $block['old']['lines']) &&
                is_array($block['old']) &&
                isset($block['new'], $block['new']['offset'], $block['new']['lines']) &&
                is_array($block['new'])
            ) {
                $oldOffset = $block['old']['offset'];
                $oldLines = $block['old']['lines'];
                $newOffset = $block['new']['offset'];
                $newLines = $block['new']['lines'];

                // process lines safely...
            } else {
                throw new \Exception('Malformed diff block: ' . json_encode($block));
            }


            // Copy unchanged lines before this block
            while ($lineIndex < $oldOffset) {
                $patchedLines[] = $baseLines[$lineIndex++];
            }

            // Replace old lines with new ones (regardless of what was removed)
            $patchedLines = array_merge($patchedLines, $newLines);

            // Skip the old lines in base content
            $lineIndex += count($oldLines);
        }

        // Add any remaining lines
        while ($lineIndex < count($baseLines)) {
            $patchedLines[] = $baseLines[$lineIndex++];
        }

        return implode("\n", $patchedLines);
    }



   public function reconstructHtmlPostVersion(int $postId, int $targetVersion): string
    {
        logger("reconstructHtmlPostVersion", [$postId, $targetVersion]);
        // Fetch all reversions from version 0 up to and including the target version
        $reversions = PostReversion::where('postid', $postId)
            ->where('version', '<=', $targetVersion)
            ->orderBy('version')
            ->get();

        if ($reversions->isEmpty()) {
            throw new \Exception("No reversions found for post ID: $postId");
        }

        $basereversion = $reversions->first();
        if ($basereversion->version !== 0 || !$basereversion->base_content) {
            throw new \Exception("Missing or invalid base_content for version 0 of post ID: $postId");
        }

        $content = $basereversion->base_content;

        // Apply diffs in order from version 1 up to targetVersion
        foreach ($reversions->skip(1) as $reversion) {

            if (empty($reversion->diff)) {
                throw new \Exception("Invalid or missing diff for version {$reversion->version}.");
            }


            $rawDiff = $reversion->diff ?? '';
            $decoded = json_decode($rawDiff, true);
            logger("decode first diff JSON", [
                $decoded,
            ]);


            logger("decode diff JSON", [
                'version' => $reversion->version,
                'diff' => $decoded,
            ]);
            if (!is_array($decoded)) {
                throw new \Exception("Invalid or missing diff for version {$reversion->version}.");
            }

            $content = $this->applyHtmlDiff($content, $decoded);

        }

        return $content;
    }



}