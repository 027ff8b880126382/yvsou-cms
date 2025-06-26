{{--
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-26
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
--}}
 
<div x-data="reversionModal()" x-init="init()" x-show="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">reversion History</h3>
            <button @click="show = false" class="text-gray-600 hover:text-red-500 text-xl">&times;</button>
        </div>

        <div x-show="loading" class="text-center text-gray-500 py-10">Loading...</div>

        <div x-show="!loading && reversions.length === 0" class="text-center text-gray-400">No reversions found.</div>

        <ul x-show="!loading" class="divide-y divide-gray-200 max-h-80 overflow-y-auto">
            <template x-for="rev in reversions" :key="rev . id">
                <li class="py-3">
                    <div class="flex justify-between items-center mb-1">
                        <div>
                            <strong x-text="rev.modified_by_name"></strong>
                            <span class="text-xs text-gray-500" x-text="rev.modified_at"></span>
                        </div>
                        <div>
                           
                            <span class="text-xs text-gray-500" x-text="rev.title"></span>
                        </div>
                        <div class="space-x-2">

                            <a :href="`/post/reversion-diff/${rev . id}/`" target="_blank"
                                class="text-blue-600 hover:underline text-sm">Diff</a>

                            <button @click="restorereversion(rev.id)"
                                class="text-green-600 hover:underline text-sm">Restore</button>
                        </div>
                    </div>
                    <div class="text-sm text-gray-700 italic" x-text="rev.preview"></div>
                </li>
            </template>
        </ul>

        <div class="pt-4 text-center" x-show="nextPageUrl">
            <button @click="loadMore" class="text-sm text-blue-600 hover:underline">Load More</button>
        </div>
    </div>
</div>

<script>
    window.reversionModalInstance = null;

    function reversionModal() {
        return {
            show: false,
            postId: null,
            loading: false,
            reversions: [],
            nextPageUrl: null,

            open(id) {
                this.show = true;
                this.postId = id;
                this.loading = true;
                fetch(`/post/${id}/reversions-json`)
                    .then(res => res.json())
                    .then(data => {
                        this.reversions = data.reversions;
                        this.nextPageUrl = data.next_page_url;
                        this.loading = false;
                    });
            },

            loadMore() {
                if (!this.nextPageUrl) return;
                this.loading = true;
                fetch(this.nextPageUrl)
                    .then(res => res.json())
                    .then(data => {
                        this.reversions.push(...data.reversions);
                        this.nextPageUrl = data.next_page_url;
                        this.loading = false;
                    });
            },

            restorereversion(id) {
                if (confirm('Are you sure you want to restore this reversion?')) {
                    fetch(`/post/restore/${id}`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(() => window.location.reload());
                }
            },

            init() {
                window.reversionModalInstance = this;
            }
        }
    }

</script>