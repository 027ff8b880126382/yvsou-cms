<?php
/**
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-16
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
use App\Models\DomainPostId;
use App\Models\DomainManager;
use Illuminate\Support\Carbon;
use App\Services\LocaleService;
use App\Services\RightsService;
use Illuminate\Support\Facades\DB;
class SearchService
{

    public function getKeywordPosts($keyword): array
    {
        $langid = (new LocaleService())->getcurlang();
        $results = $this->getpostfromkeys($keyword);
        $postlines = [];
        foreach ($results as $item) {
            $postsQuery = DB::table('domain_post_ids')
                ->useIndex('gDate')
                ->select('postid', 'lang', 'groupid')
                ->where('isTrash', 0)
                ->where('postid', $item->postid)
                ->where('lang', $langid);

            foreach ($postsQuery as $row) {
                $postId = $row->postid;
                $groupId = trim($row->groupid);
                $title = (new PostService())->getPostTitle($postId); 
                if (trim($title) === '') {
                    continue;
                }
                if ((new RightsService())->checkFileAccess($groupId, $postId)) {
                    //   if ((new RightsService())->checkRightPermission($groupId, 'SHOWDIR')) {
                    $url = route('post.index', ['groupid' => $groupId, 'pid' => $postId]);
                    $postlines[] = ['url' => $url, 'title' => $title,'groupid'=> $groupId,'postid'=> $postId ];
                }
            }

        }
 
        return $postlines;
    }

    function getpostfromkeys($likeitem)
    {

        $query = DB::table('domain_posts')
            ->where(function ($q) use ($likeitem) {
                $q->where('post_title', 'like', "%{$likeitem}%")
                    ->orWhere('post_content', 'like', "%{$likeitem}%");
            })->get();

        return $query;
    }


    public function showNewDirs(): array
    {

        $counts = 15;

        $items = DomainManager::where('bTrash', 0)
            ->orderByDesc('cDate')
            ->limit($counts)
            ->get(['domainid'])
            ->reverse();

        $dirlines = [];
        $rightsService = new RightsService();
        $domainService = new DomainService();

        foreach ($items as $item) {
            $domainId = $item['domainid'];
            if (trim($domainId) == "")
                continue;

            if ($rightsService->checkRightPermission($domainId, 'SHOWDIR')) {

                $url = route('post.postview', ['groupid' => urlencode($domainId)]);
                // dd($url);
                //  $url = route('post.postview', ['groupid' => "1"]);
                $title = $domainService->get_jointitle_by_uniqid($domainId);

                $dirlines[] = [
                    'url' => $url,
                    'title' => $title
                ];
            }
        }
        //  dd($dirlines);
        return $dirlines;
    }


}

