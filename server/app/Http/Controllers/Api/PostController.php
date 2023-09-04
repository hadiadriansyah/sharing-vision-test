<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::where('status', $request->status)->orderBy('updated_date', 'Desc')->paginate(5);
        return PostResource::collection($posts);
    }

    public function artGetPagination(Request $request)
    {
        $posts = Post::select("*")->limit($request->limit)->offset($request->offset)->get();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status,
        ];
        Post::create($data);

        return response($data, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
         $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status,
        ];

        Post::where('id', $id)->update($data);

        return response($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Post::where('id', $id)->delete();

        $data = [
            'status' => 'Trash'
        ];
        Post::where('id', $id)->update($data);

        return response(['message' => 'Send to trash']);
    }
}
