 
<div>
    {{-- Add reply form or buttons based on permissions --}}
    {{-- Check if user can reply new top comment--}}
    @auth

        @if(Auth::user()->canComment($pid, $groupid, 'WRITE'))
            {{-- Reply Button --}}
            <button onclick="document.getElementById('reply-form-{{ $pid}}').classList.toggle('hidden')"
                class="mt-2 px-4 py-1 bg-green-500 text-white rounded">
                {{ $rfreply ?? 'Reply' }}
            </button>

            {{-- Hidden Reply Form --}}
            <div id="reply-form-{{ $pid }}" class="hidden mt-4">
                <form method="POST" action="{{ route('post.commentstore') }}" class="comment-reply-form">
                    @csrf
                    <input type="hidden" name="groupid" value="{{$groupid}}">
                    <input type="hidden" name="comment_postid" value={{$pid}}>
                    <textarea name="comment_content" rows="5" class="w-full mt-2 border rounded p-2"
                        placeholder="Your reply..."></textarea>
                    <button type="submit"
                        class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">{{ $rsubmit ?? 'Submit Reply' }}</button>
                </form>
            </div>
        @endif
    @else
        {{-- User is not logged in --}}
        <p>{{ $cneedloginreply ?? 'Please log in to reply.' }}
            <a href="{{ route('login') }}" class="text-blue-500 underline">{{ $rlogin ?? 'Login' }}</a>
        </p>
    @endauth
    @foreach($comments as $comment)
        @include('comment.partials.partialcomment', ['comment' => $comment])
    @endforeach
</div>