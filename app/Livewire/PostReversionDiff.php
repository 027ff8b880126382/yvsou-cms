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


namespace App\Livewire;

use Livewire\Component;
use App\Models\PostReversion;
use Jfcherng\Diff\DiffHelper;
use App\Services\ReversionService;

class PostReversionDiff extends Component
{
    public $reversionId;
    public $reversion;
    public $baseContent;
    public $diffHtml;
 
    function styleHtmlDiff(string $html): string
    {
        return str_replace(
            ['<ins>', '<del>'],
            [
                '<ins class="bg-green-100 text-green-800 no-underline transition hover:bg-green-200 hover:text-green-900">',
                '<del class="bg-red-100 text-red-800 line-through transition hover:bg-red-200 hover:text-red-900">'
            ],
            $html
        );
    }
    public function mount($reversionId)
    {
        $this->reversionId = $reversionId;
        $this->reversion = PostReversion::findOrFail($reversionId);
        if ($this->reversion->version <= 0) {
            $old = (new ReversionService())->reconstructHtmlPostVersion($this->reversion->postid, 0);
            $new = (new ReversionService())->reconstructHtmlPostVersion($this->reversion->postid, 0);
            $old = html_entity_decode($old, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $new = html_entity_decode($new, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $this->diffHtml = DiffHelper::calculate($old, $new, 'SideBySide', ['context' => 3]);

        } else {
            $old = (new ReversionService())->reconstructHtmlPostVersion($this->reversion->postid, $this->reversion->version - 1);
            $new = (new ReversionService())->reconstructHtmlPostVersion($this->reversion->postid, $this->reversion->version);
            $old = html_entity_decode($old, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $new = html_entity_decode($new, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $this->diffHtml = DiffHelper::calculate($old, $new, 'SideBySide', ['context' => 3]);

        }
        //   $this->diffHtml = $this->styleHtmlDiff($this->diffHtml);

    }

    public function render()
    {
        return view('livewire.post-reversion-diff')->layout('layouts.app');
    }
}
