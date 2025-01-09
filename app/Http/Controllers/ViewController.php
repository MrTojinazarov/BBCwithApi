<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function incrementViewCount($postId)
    {
        $ipAddress = request()->ip(); 
        $viewExists = View::where('post_id', $postId)
                          ->where('user_ip', $ipAddress)
                          ->first(); 

        if (!$viewExists) {
            View::create([ 
                'post_id' => $postId,
                'user_ip' => $ipAddress,
            ]);

            $post = Post::find($postId);
            $post->increment('views');
        }

        return response()->json([
            'success' => true,
            'message' => 'Post views count updated successfully.',
        ]);
    }
}


