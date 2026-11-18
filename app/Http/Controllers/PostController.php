<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'tags']);

        if ($request->get('filter') === 'drafts') {
            $query->drafts();
        } elseif ($request->get('filter') === 'popular') {
            $query->published()->popular();
        } elseif ($request->get('filter') === 'trash') {
            $query->onlyTrashed();
        } else {
            $query->published();
        }

        $posts = $query->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name'  => 'required|min:2|max:100',
            'author_email' => 'required|email',
            'title'        => 'required|min:3|max:255',
            'content'      => 'required|min:5',
            'status'       => 'required|in:draft,published',
            'tags'         => 'nullable|array',
        ], [
            'author_name.required'  => 'Введите ваше имя.',
            'author_email.required' => 'Введите email автора.',
            'title.required'        => 'Укажите название статьи.',
        ]);

        $user = User::firstOrCreate(
            ['email' => $validated['author_email']],
            [
                'name' => $validated['author_name'],
                'password' => bcrypt('secret123')
            ]
        );
        $post = $user->posts()->create([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'status'  => $validated['status'],
        ]);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('posts.index')->with('success', 'Статья успешно опубликована!');
    }

    public function show(Post $post)
    {
        $post->increment('views_count');

        $post->load(['comments', 'tags', 'user']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'   => 'required|min:3|max:255',
            'content' => 'required|min:5',
            'status'  => 'required|in:draft,published',
            'tags'    => 'nullable|array',
        ]);

        $post->update($validated);

        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('posts.show', $post)->with('success', 'Пост успешно обновлен!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост удален!');
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|min:2',
        ]);

        $post->comments()->create([
            'body' => $request->body,
        ]);

        return back()->with('success', 'Комментарий добавлен!');
    }
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore(); 

        return redirect()->route('posts.index')->with('success', 'Статья успешно восстановлена из корзины!');
    }
}