<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\KafkaService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Monolog\Handler\ElasticSearchHandler;

class CodeController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function top()
    {
        return response()->json([
            'status' => 0,
            'msg' => 'ok',
            'data' => $this->postService->responseTopThreePosts()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            $posts = $this->postService->searchPosts($request->q);
        } else{
            $posts = $this->postService->getPostsByUpdateTime();
        }
        return response([
            'status' => 0,
            'message' => 'success',
            'data' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $post = Post::create([
            'user_id' => $user->id,
            'tag_id' => $request->tag_id,
            'title' => $request->title,
            'content' => $request->input('content'),
            'thumbnail' => $request->thumbnail
        ]);

        $user->update([
            'update_post' => Carbon::now()
        ]);

        KafkaService::produce(json_encode([
            'type' => 'elasticsearch',
            'data' => $post->load('tag')->toArray()
        ]));

        return response()->json([
            'status' => 0,
            'message' => 'success',
            'data' => $post
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $post->update([
            'read_count' => $post->read_count + 1
        ]);
        if (!$post) {
            return response([
                'status' => 1,
                'message' => 'not found post',
            ]);
        }
        return response([
            'status' => 0,
            'message' => 'success',
            'data' => $post->load('tag', 'user')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
