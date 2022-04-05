@extends('layouts.app')

@section('content')
<div class="container">
<header>
    <h1>Nuovo Post</h1>
</header>
<hr/>

@include('includes.posts.form')
</div>

@endsection


@section('script')
<script src="{{asset('js/image-preview.js')}}"></script>
@endsection