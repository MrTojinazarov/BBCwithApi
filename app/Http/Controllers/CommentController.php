<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'body' => $request->input('message'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sharhingiz muvaffaqiyatli yuborildi.',
            'comment' => $comment,
        ]);
    }
}
