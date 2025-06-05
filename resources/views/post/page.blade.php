</br>
{!! $domain_links !!}

</br>
</br>
<tr class="border-b">
    <td class="px-4 py-2">{!! $post_title !!}</td> &nbsp;&nbsp;&nbsp;&nbsp;
    <td class="px-4 py-2 text-right">
        <div x-data="{ open: false }" class="relative inline-block text-left">
            <button @click="open = !open" @click.away="open = false"
                class="inline-flex justify-center w-full px-3 py-1 text-sm font-medium bg-gray-100 rounded hover:bg-gray-200">
                Actions
                <svg class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" x-transition
                class="absolute right-0 z-50 mt-2 w-40 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                <a href="{{ route('post.edit', ['groupid' => $groupid, 'pid' => $pid]) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ Edit</a>

                <a href="{{ route('post.movegroup', ['groupid' => $groupid, 'pid' => $pid]) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ Move to Group</a>
                    
                <a href="{{ route('post.copygroup', ['groupid' => $groupid, 'pid' => $pid]) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ Copy to Group</a>
                <a href="{{ route('post.movelang', ['groupid' => $groupid, 'pid' => $pid]) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">✏️ Move Language</a>

                <button onclick="window.reversionModalInstance?.open({{ $pid }})"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    📜 History
                </button>

                <form method="POST" action="{{ route('post.auditcheck', compact('groupid', 'pid'))}}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                        audit checck </button>
                </form>

                <form method="POST" action="{{ route('post.audituncheck', compact('groupid', 'pid'))}}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                        audit uncheck </button>
                </form>


                <form method="POST" action="{{ route('post.trash', compact('groupid', 'pid'))}}"
                    onsubmit="return confirm('Are you sure you want to trash this post?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                        Trash post</button>
                </form>
                <form method="POST" action="{{ route('post.untrash', compact('groupid', 'pid'))}}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                        unTrash post</button>
                </form>


                <form method="POST" action="{{ route('post.destroy', compact('groupid', 'pid'))}}"
                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🗑️
                        Delete Post</button>
                </form>

            </div>
        </div>
    </td>
</tr>
</br>
<td class="px-4 py-2">{{ $author_by }}</td>

</br>
</br>
{!! $content !!}
</div>