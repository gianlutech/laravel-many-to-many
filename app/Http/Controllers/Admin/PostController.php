<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublishedPostMail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.create', compact('tags', 'post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        //dd($request->all());

        $request->validate([
            'title' => 'required|string|unique:posts|min:5|max:50',
            'content' => 'required|string',
            'image' => 'nullable|image',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ], [
            'required.title' => 'Il titolo è obbligatorio',
            'min.title' => 'La lunghezza minima del titolo è di 5 caratteri',
            'max.title' => 'La lunghezza massima del titolo è di 50 caratteri',
            'unique.title' => "Esiste già un post dal titolo $request->title",
            'tags.exists' => 'Uno dei tag selezionati non è valido'
        ]);

        $data = $request->all();
        $post = new Post();

        if(array_key_exists('image', $data)) {
           $img_url = Storage::put('post_images', $data['image']);
           $data['image'] = $img_url;
        }

        $post->fill($data);
        $post->slug = Str::slug($post->title, '-');
        $post->save();

        //mando la mail di conferma

        $mail = new PublishedPostMail($post);
        $receiver = Auth::user()->email;
        Mail::to($receiver)->send($mail);


        if(array_key_exists('tags', $data)) $post->tags()->attach($data['tags']);

        return redirect()->route('admin.posts.index')->with('message', 'Post creato con successo!')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();

        $categories = Category::all();
        return view('admin.posts.edit', compact('tags', 'post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => ['required', 'string', Rule::unique('posts')->ignore($post->id),' min:5', 'max:50'],
            'content' => 'required|string',
            'image' => 'nullable|image',
            'category_id' => 'nullable|exists:categories,id'
        ], [
            'required.title' => 'Il titolo è obbligatorio',
            'min.title' => 'La lunghezza minima del titolo è di 5 caratteri',
            'max.title' => 'La lunghezza massima del titolo è di 50 caratteri',
            'unique.title' => "Esiste già un post dal titolo $request->title",
        ]);

        $data = $request->all();

        $data['slug'] = Str::slug($request->title, '-');

        if(array_key_exists('image', $data)) {
            if($post->image) Storage::delete($post->image);

            $img_url = Storage::put('post_images', $data['image']);
            $data['image'] = $img_url;
        }

        $post->update($data);

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->image) Storage::delete($post->image);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', "Il post $post->title è stato eliminato")->with('type', 'danger');
    }
}
