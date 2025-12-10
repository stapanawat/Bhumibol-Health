<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Doctor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Get search suggestions.
     */
    public function suggest(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        // Search Posts (News)
        $posts = Post::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title_th', 'like', "%{$query}%")
                    ->orWhere('title_en', 'like', "%{$query}%");
            })
            ->latest('published_at')
            ->take(5)
            ->get(['id', 'title_th', 'title_en', 'slug', 'image']);

        // Search Doctors
        $doctors = Doctor::where(function ($q) use ($query) {
            $q->where('name_th', 'like', "%{$query}%")
                ->orWhere('name_en', 'like', "%{$query}%")
                ->orWhere('specialty_th', 'like', "%{$query}%")
                ->orWhere('specialty_en', 'like', "%{$query}%");
        })
            ->take(3)
            ->get(['id', 'name_th', 'name_en', 'specialty_th', 'image']);

        return response()->json([
            'posts' => $posts->map(function ($post) {
                return [
                    'type' => 'news',
                    'title' => $post->title_th, // Prefer Thai
                    'subtitle' => 'News',
                    'url' => route('news.show', $post->slug),
                    'image' => $post->image ? "/storage/{$post->image}" : null,
                ];
            }),
            'doctors' => $doctors->map(function ($doctor) {
                return [
                    'type' => 'doctor',
                    'title' => $doctor->name_th, // Prefer Thai
                    'subtitle' => $doctor->specialty_th,
                    'url' => route('doctors.index'), // Or specific doctor page if exists
                    'image' => $doctor->image ? "/storage/{$doctor->image}" : null,
                ];
            }),
        ]);
    }
}
