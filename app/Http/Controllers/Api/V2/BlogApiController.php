<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BlogApiController extends Controller
{
    private function formatPost(BlogPost $post): array
    {
        return [
            'id'          => (string) $post->id,
            'slug'        => $post->slug,
            'title'       => [
                'uz' => $post->title_uz ?? '',
                'ru' => $post->title_ru ?? '',
                'en' => $post->title_en ?? '',
            ],
            'excerpt'     => [
                'uz' => $post->excerpt_uz ?? '',
                'ru' => $post->excerpt_ru ?? '',
                'en' => $post->excerpt_en ?? '',
            ],
            'content'     => [
                'uz' => $post->content_uz ?? '',
                'ru' => $post->content_ru ?? '',
                'en' => $post->content_en ?? '',
            ],
            'image'       => $post->image,
            'author'      => $post->author ?? '',
            'publishDate' => $post->publish_date ? $post->publish_date->format('Y-m-d') : ($post->created_at ? $post->created_at->format('Y-m-d') : ''),
            'category'    => $post->relationLoaded('category') && $post->category ? [
                'id'    => $post->category->id,
                'slug'  => $post->category->slug,
                'title' => $post->category->title_uz ?? '',
            ] : null,
            'tags'        => $post->relationLoaded('tags') ? $post->tags->map(fn($t) => [
                'id'    => $t->id,
                'slug'  => $t->slug,
                'title' => $t->title_uz ?? '',
            ])->values()->toArray() : [],
            'images'      => [
                'main' => $post->image ? [
                    'url'   => $post->image,
                    'thumb' => $post->image,
                    'card'  => $post->image,
                    'full'  => $post->image,
                ] : null,
            ],
            'viewsCount'  => $post->views_count ?? 0,
            'video'       => $post->video,
            'audio'       => $post->audio,
        ];
    }

    public function index(Request $request): JsonResponse
    {
        $query = BlogPost::published()->with(['category', 'tags'])->orderByDesc('publish_date');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_uz', 'ilike', "%{$search}%")
                  ->orWhere('title_ru', 'ilike', "%{$search}%")
                  ->orWhere('title_en', 'ilike', "%{$search}%");
            });
        }

        $perPage = min((int) $request->get('per_page', 10), 100);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'result'  => [
                'data'       => array_map(fn($p) => $this->formatPost($p), $paginated->items()),
                'pagination' => [
                    'total'        => $paginated->total(),
                    'per_page'     => $paginated->perPage(),
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                    'from'         => $paginated->firstItem(),
                    'to'           => $paginated->lastItem(),
                ],
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $post = BlogPost::published()
            ->with(['category', 'tags', 'comments' => fn($q) => $q->where('is_approved', true)->orderBy('created_at')])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views_count');

        $comments = $post->comments->map(fn($c) => [
            'id'      => $c->id,
            'author'  => $c->author ?? 'Anonim',
            'message' => $c->message,
            'date'    => $c->created_at?->format('Y-m-d H:i'),
        ])->values()->toArray();

        $formatted = $this->formatPost($post);
        $formatted['comments'] = $comments;

        return response()->json([
            'success' => true,
            'result'  => ['data' => $formatted],
        ]);
    }

    public function latest(Request $request): JsonResponse
    {
        $limit = min((int) $request->get('limit', 5), 20);
        $posts = BlogPost::published()
            ->with(['category'])
            ->orderByDesc('publish_date')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $posts->map(fn($p) => $this->formatPost($p))->values()->toArray()],
        ]);
    }

    public function popular(Request $request): JsonResponse
    {
        $limit = min((int) $request->get('limit', 5), 20);
        $posts = BlogPost::published()
            ->with(['category'])
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $posts->map(fn($p) => $this->formatPost($p))->values()->toArray()],
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = BlogCategory::withCount(['posts' => fn($q) => $q->published()])->get();

        return response()->json([
            'success' => true,
            'result'  => ['data' => $categories->map(fn($c) => [
                'id'         => $c->id,
                'slug'       => $c->slug,
                'title'      => ['uz' => $c->title_uz, 'ru' => $c->title_ru, 'en' => $c->title_en],
                'posts_count'=> $c->posts_count,
            ])->values()->toArray()],
        ]);
    }

    public function comments(int $postId): JsonResponse
    {
        BlogPost::findOrFail($postId);
        $comments = BlogComment::where('blog_post_id', $postId)
            ->where('is_approved', true)
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'result'  => [
                'data'  => $comments->map(fn($c) => [
                    'id'      => $c->id,
                    'author'  => $c->author ?? 'Anonim',
                    'message' => $c->message,
                    'date'    => $c->created_at?->format('Y-m-d H:i'),
                ])->values()->toArray(),
                'total' => $comments->count(),
            ],
        ]);
    }

    public function storeComment(Request $request, int $postId): JsonResponse
    {
        BlogPost::findOrFail($postId);

        try {
            $validated = $request->validate([
                'author'   => 'nullable|string|max:255',
                'message'  => 'required|string|max:2000',
                'reply_to' => 'nullable|integer|exists:blog_comments,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }

        $comment = BlogComment::create([
            'blog_post_id' => $postId,
            'author'       => $validated['author'] ?? 'Anonim',
            'message'      => $validated['message'],
            'reply_to'     => $validated['reply_to'] ?? null,
            'is_approved'  => true,
        ]);

        return response()->json([
            'success' => true,
            'result'  => ['data' => [
                'id'      => $comment->id,
                'author'  => $comment->author,
                'message' => $comment->message,
                'date'    => $comment->created_at?->format('Y-m-d H:i'),
            ]],
        ], 201);
    }
}
