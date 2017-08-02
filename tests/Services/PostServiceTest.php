<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testResponseTopThreePosts()
    {
        $data = collect([]);
        $postRepository = Mockery::mock(\App\Repositories\PostRepository::class);
        $postRepository->shouldReceive('getTopThreeWithTag')->once()->andReturn($data);
        App::instance(\App\Repositories\PostRepository::class, $postRepository);
        $expected = $data->toArray();
        $actual = app(\App\Services\PostService::class)->responseTopThreePosts();
        $this->assertEquals($expected, $actual);
    }
}
