@extends('layouts.app')

@section('content')
<div class="py-8">
    <livewire:posts.edit-post :post="$post" />
</div>
@endsection
