@extends('layouts.app')

@section('content')
<div class="container">

    <h1>{{$post->title}}</h1>
    @if($post->image) <img src="{{$post->image}}" alt="{{$post->slug}}"> @endif
    <p>{{$post->content}}</p>
    <time>{{$post->created_at}}</time>
 
    <hr>
    <div class="d-flex align -items-center justify-content-end">
        <a href="{{route('admin.posts.edit', $post->id)}}" class="btn btn-sm btn-warning mr-2"><i class="fa-solid fa-pen"> Modifica</i></a>
        <form action="{{route('admin.posts.destroy', $post->id)}}" method="POST" class="delete-form">
            @METHOD('delete')
            @csrf
            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"> Elimina</i></button>
        </form>
        <a href="{{route('admin.posts.index')}}" class="btn btn-secondary ml-2">
        <i class="fa-solid fa-circle-arrow-left"> Indietro</i>
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{asset('js/delete-confirm.js')}}" defer></script>
@endsection