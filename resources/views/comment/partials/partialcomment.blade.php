 
{{-- resources/views/comments/partials/partialcomment.blade.php --}}
<div class="comment">
    <div>
        <strong>{{ $comment->user->name ?? 'Guest' }}</strong> • {{ $comment->comment_date }}
    </div>
    <div>
        {!! nl2br(e($comment->comment_content))  . " <ins>PostVer  $comment->post_version  </ins>" !!}
    </div>

    {{-- Add reply form or buttons based on permissions --}}
    {{-- Check if user can reply --}}
    @auth

        @if(Auth::user()->canComment($pid, $groupid, 'WRITE'))

            {{-- Reply Form --}}
            {{-- Reply Button --}}
            <button onclick="toggleReplyForm({{ $comment->id }})" class="text-blue-500 hover:underline">Reply</button>

            {{-- Hidden Reply Form --}}
            <div id="reply-form-{{ $comment->id }}" style="display: none;" class="mt-2">
                <form method="POST" action="{{ route('post.commentstore') }}" class="comment-reply-form">
                    @csrf
                    <input type="hidden" name="groupid" value="{{ $groupid }}">
                    <input type="hidden" name="comment_postid" value="{{ $pid }}">
                    <input type="hidden" name="comment_parent" value="{{ $comment->id }}">

                    <textarea name="comment_content" rows="5" class="w-full mt-2 border rounded p-2"></textarea>
                    <button type="submit"
                        class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">{{ $rsubmit ?? 'Submit Reply' }}</button>
                </form>
            </div>

            <script>
                function toggleReplyForm(commentId) {
                    const form = document.getElementById(`reply-form-${commentId}`);
                    if (form.style.display === 'none') {
                        form.style.display = 'block';
                        form.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        form.style.display = 'none';
                    }
                }
            </script>

        @endif
    @else
        {{-- User is not logged in --}}
        <p>{{ $cneedloginreply ?? 'Please log in to reply.' }}
            <a href="{{ route('login') }}" class="text-blue-500 underline">{{ $rlogin ?? 'Login' }}</a>
        </p>
    @endauth


    @if($comment->children->count())
        <div class="ml-6">
            @foreach($comment->children as $child)
                @include('comment.partials.partialcomment', ['comment' => $child])
            @endforeach
        </div>
    @endif
</div>