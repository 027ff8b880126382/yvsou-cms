 
 <div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Post reversion Diff</h1>

    <div class="bg-white shadow rounded p-4 overflow-auto prose max-w-none">
        {!! $diffHtml !!}
    </div>

    <div class="mt-6">
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">← Back</a>
    </div>
</div>
