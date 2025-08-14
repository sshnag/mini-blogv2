@extends('layouts.app')

@section('content')
<livewire:posts.post-show :post="$post" />
@endsection
