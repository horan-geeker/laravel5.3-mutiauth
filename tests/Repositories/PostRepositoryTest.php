<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * use database test
     *
     * @return void
     */
    public function testGetTopThreeWithTagEqualToThree()
    {
        $target = app(\App\Repositories\PostRepository::class);
        $expected = 3;

        $actual = $target->getTopThreeWithTag()->count();

        $this->assertEquals($expected, $actual);
    }

    public function testGetTopThreeWithTagCalledByService()
    {
        $expected = new \Illuminate\Database\Eloquent\Collection([
            ['name' => 'oomusou', 'email' => 'oomusou@gmail.com'],
            ['name' => 'sam',     'email' => 'sam@gmail.com'],
            ['name' => 'sunny',   'email' => 'sunny@gmail.com'],
        ]);
        $repository = Mockery::mock(\App\Repositories\PostRepository::class);
        $repository->shouldReceive('getTopThreeWithTag')->once()->andReturn($expected);
        App::instance(\App\Repositories\PostRepository::class, $repository);
        // Act...
        App::make(\App\Services\PostService::class)->responseTopThreePosts();
    }
}
