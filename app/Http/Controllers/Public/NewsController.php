<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Doctor;
use Inertia\Inertia;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display the home page with latest news.
     */
    public function home()
    {
        $heroPost = Post::with('category')
            ->where('status', 'published')
            ->where('is_pinned', true)
            ->latest('published_at')
            ->first();

        $latestNews = Post::with('category')
            ->where('status', 'published')
            ->where('id', '!=', $heroPost?->id) // Exclude hero post
            ->latest('published_at')
            ->take(6)
            ->get();

        $doctors = Doctor::orderBy('order')->take(4)->get();

        return Inertia::render('Welcome', [
            'heroPost' => $heroPost,
            'latestNews' => $latestNews,
            'doctors' => $doctors
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user'])
            ->where('status', 'published');

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_th', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return Inertia::render('News/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category'])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = Post::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $post->increment('views');

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return Inertia::render('News/Show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}
