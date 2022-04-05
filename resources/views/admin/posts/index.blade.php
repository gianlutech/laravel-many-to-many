@extends('layouts.app') 

@section('content')
<div class="container">
    <header class="d-flex align-items-center justify-content-between">
        <h1>I miei post</h1>
        <a href="{{route('admin.posts.create')}}" class="btn btn-success">
        <i class="fa-solid fa-plus"> aggiungi</i>
        </a>
    </header>
    @if(session('message'))
    <div class="alert alert-{{session('type') ?? 'info' }}">
        {{session('message')}}
    </div>
    @endif
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titolo</th>
      <th scope="col">Categoria</th>
      <th scope="col">Creato il </th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
      @forelse($posts as $post)
      <tr>
        <th scope="row">{{$post->id}}</th>
        <td>{{$post->title}}</td>
        <td> @if($post->category) {{$post->category->label}} @else - @endif</td>
        <td>{{$post->created_at}}</td>
        <td class="d-flex justify-content-end align-items-center">
            <a href="{{route('admin.posts.show', $post->id)}}" class="btn btn-sm btn-primary mr-2">
            <i class="fa-solid fa-eye "></i>
            </a>

            <a href="{{route('admin.posts.edit', $post->id)}}" class="btn btn-sm btn-warning mr-2"><i class="fa-solid fa-pen"></i></a>

            <form action="{{route('admin.posts.destroy', $post->id)}}" method="POST" class="delete-form">
            @METHOD('delete')
            @csrf
            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
        </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5"><h3>Non ci sono post</h3></td></tr>
      @endforelse
    
  </tbody>
</table>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/delete-confirm.js')}}" defer></script>
@endsection