<?php
/**
 * Created by PhpStorm.
 * User: hejunwei
 * Date: 01/08/2017
 * Time: 13:50
 */

namespace App\Services;

use App\Repositories\PostRepository;
use PhpParser\Node\Expr\Array_;
use Psy\Util\Json;

class PostService
{

    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return array
     */
    public function responseTopThreePosts()
    {
        return $this->postRepository->getTopThreeWithTag()->toArray();
    }

    public function getPostsByUpdateTime()
    {
        return $this->postRepository->getAllByUpdateTime();
    }

    public function searchPosts($query)
    {
        $fetch = $this->postRepository->searchPosts($query);
        $data = [];
        if ($fetch) {
            foreach ($fetch as $item) {
                $row = $item['_source'];
                $row['tag']['type'] = $item['_source']['tags'][0];
                $row['id'] = $item['_id'];
                $data[] = $row;
            }
            return $data;
        }
        return $data;
    }

}