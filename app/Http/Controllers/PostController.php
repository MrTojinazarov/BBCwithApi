<?php 
namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $all = Post::orderBy('id', 'desc')->paginate(10);
        $categories = Category::all();
        return response()->json([
            'posts' => $all,
            'categories' => $categories,
        ]);
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;
            $file->move(public_path('img_uploded'), $filename);
            $data['img'] = 'img_uploded/' . $filename;
        }

        Post::create(array_merge($data, [
            'likes' => 0,
            'dislikes' => 0,
            'views' => 0,
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('views'); 

        return response()->json([
            'post' => $post,
        ]);
    }

    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;
            $file->move(public_path('img_upload'), $filename); 
            $data['img'] = 'img_upload/' . $filename; 
        } else {
            $data['img'] = $request->input('old_img');
        }

        $post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully.',
        ]);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.',
        ]);
    }

    public function like($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('likes'); 

        return response()->json([
            'success' => true,
            'message' => 'Postga like berildi.',
        ]);
    }

    public function dislike($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('dislikes'); 

        return response()->json([
            'success' => true,
            'message' => 'Postga dislike berildi.',
        ]);
    }
}
