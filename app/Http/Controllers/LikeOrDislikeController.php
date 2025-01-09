<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LikeOrDislike;
use App\Models\Post;

class LikeOrDislikeController extends Controller
{
    public function like(Request $request, $postId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to like the post.'
            ], 401); 
        }

        $post = Post::findOrFail($postId);

        $like = LikeOrDislike::where('post_id', $post->id)->where('user_id', Auth::id())->first();

        if ($like) {
            if ($like->value == 1) {
                $like->delete();
                $post->decrement('likes');
                return response()->json([
                    'success' => true,
                    'message' => 'Like removed.',
                    'likes' => $post->likes
                ]);
            } else {
                $like->value = 1;
                $like->save();
            }
        } else {
            LikeOrDislike::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'value' => 1,
            ]);
        }

        $post->increment('likes');

        return response()->json([
            'success' => true,
            'message' => 'Post liked successfully.',
            'likes' => $post->likes
        ]);
    }

    public function dislike(Request $request, $postId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to dislike the post.'
            ], 401);
        }

        $post = Post::findOrFail($postId);

        $dislike = LikeOrDislike::where('post_id', $post->id)
                                 ->where('user_id', Auth::id())
                                 ->first();

        if ($dislike) {
            if ($dislike->value == -1) {
                $dislike->delete();
                $post->decrement('dislikes');
                return response()->json([
                    'success' => true,
                    'message' => 'Dislike removed.',
                    'dislikes' => $post->dislikes
                ]);
            } else {
                $dislike->value = -1;
                $dislike->save();
            }
        } else {
            LikeOrDislike::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'value' => -1,
            ]);
        }

        $post->increment('dislikes');

        return response()->json([
            'success' => true,
            'message' => 'Post disliked successfully.',
            'dislikes' => $post->dislikes
        ]);
    }
}
