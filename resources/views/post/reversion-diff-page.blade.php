@extends('layouts.app')

@section('content')
    <livewire:post-reversion-diff :reversion-id="$reversionId" />
@endsection
