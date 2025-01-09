<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Savol;
use Illuminate\Http\Request;

class BBCController extends Controller
{
    protected $viewController;

    public function __construct()
    {
        $this->viewController = new ViewController();
    }

    public function index()
    {
        $posts = Post::withCount(['likes', 'dislikes'])
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->paginate(6);
        
        $categories = Category::where('is_active', true)->get();
        
        $new_posts = Post::withCount(['likes', 'dislikes'])
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
    
        $savols = Savol::all();
        
        return response()->json([
            'posts' => $posts,
            'categories' => $categories,
            'new_posts' => $new_posts,
            'savols' => $savols,
        ]);
    }
    
    public function byCategory($id)
    {
        $categories = Category::where('is_active', true)->get();
    
        $posts = Post::where('category_id', $id)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->withCount(['likes', 'dislikes'])
            ->paginate(6);
    
        $new_posts = Post::where('category_id', $id)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->withCount(['likes', 'dislikes'])
            ->get();
    
        $savols = Savol::all();

        return response()->json([
            'posts' => $posts,
            'categories' => $categories,
            'new_posts' => $new_posts,
            'savols' => $savols,
        ]);
    }
    
    public function single($id)
    {
        $categories = Category::where('is_active', true)->get();
    
        $post = Post::whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->withCount(['likes', 'dislikes'])
            ->findOrFail($id);
    
        $new_posts = Post::whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->withCount(['likes', 'dislikes'])
            ->get();
    
        $comments = Comment::where('post_id', $id)->with('user')->get();
    
        $savols = Savol::all();

        $this->viewController->incrementViewCount($id);
    
        return response()->json([
            'post' => $post,
            'categories' => $categories,
            'new_posts' => $new_posts,
            'likes_count' => $post->likes_count,
            'dislikes_count' => $post->dislikes_count,
            'views_count' => $post->views,
            'comments' => $comments,
            'savols' => $savols,
        ]);
    }
}
