@extends('layouts.app')

@section('content')
<livewire:posts.post-show :slug="$post->slug" />
@endsection
