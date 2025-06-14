<?php
/**
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-14
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
// app/Http/Livewire/DomainTree.php

namespace App\Livewire;
use Livewire\Component as LivewireComponent;

use App\Services\DomainService;
use App\Models\DomainTreeChildId;
use App\Models\DomainManager;


class ShowDomainTree extends LivewireComponent
{
    public $expanded = [];
    public $children = [];
    public $groupgid = null;
    public $id;
    public $rootDomain;

    public function mount()
    {
        // Load the single root domain (assuming only one root)
        // $rootgroupid  = DomainTreeChildId::whereNull('child_id')->first();
        $rootgroupid = DomainManager::getFirstGroupid();
        $this->groupgid = $rootgroupid;


        if ($rootgroupid) {
            // Load the first-level children immediately
            $childids = (new DomainService())->get_children_by_groupid($rootgroupid);
            $this->children[] = $childids;
            $this->expanded[] = $rootgroupid; // root expanded by default
        }
    }

    public function toggle($id)
    {
        if (in_array($id, $this->expanded)) {
            // Collapse node
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            // Expand node and lazy load children if not loaded yet
            $this->expanded[] = $id;

            if (!isset($this->children[$id])) {
                $this->children[$id] = ShowDomainTree::where('parent_id', $id)->get();
            }
        }
    }

    public function render()
    {

        return view('livewire.show-domain-tree', [

            'rootDomain' => $this->rootDomain,
            'children' => $this->children,
            'expanded' => $this->expanded,

        ]);

    }
}
