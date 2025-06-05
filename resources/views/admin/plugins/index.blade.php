@extends('layouts.app')

@section('content')

    <h1>Plugin Manager</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Name</th>
                <th>Version</th>
                <th>Status</th>
                <th>Dependencies</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($plugins as $plugin)
            <tr>
                <td>{{ $plugin['name'] }}</td>
                <td>{{ $plugin['version'] }}</td>
                <td>{{ $plugin['enabled'] ? 'Enabled' : 'Disabled' }}</td>
                <td>
                    <pre>{{ json_encode($plugin['dependencies'], JSON_PRETTY_PRINT) }}</pre>
                </td>
                <td>
                    <a href="{{ url('/admin/plugins/toggle/'.$plugin['name']) }}">
                        {{ $plugin['enabled'] ? 'Disable' : 'Enable' }}
                    </a> |
                    <a href="{{ url('/admin/plugins/delete/'.$plugin['name']) }}">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Upload Plugin</h2>
    <form action="{{ url('/admin/plugins/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="plugin_zip" required>
        <button type="submit">Upload ZIP</button>
    </form>
@endsection
