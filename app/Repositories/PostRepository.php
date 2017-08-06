<?php
namespace App\Repositories;
use App\Models\Post;
use App\Services\ElasticSearch;

/**
 * Created by PhpStorm.
 * User: hejunwei
 * Date: 01/08/2017
 * Time: 11:39
 */
class PostRepository
{
    protected $post;
    protected $elasticSearch;

    public function __construct(Post $post, ElasticSearch $elasticSearch)
    {
        $this->post = $post;
        $this->elasticSearch = $elasticSearch;
    }

    /**
     * @return array
     */
    public function getTopThreeWithTag()
    {
       return $this->post->with('tag')->orderBy('read_count', 'DESC')->take(3)->get();
    }

    public function getAllByUpdateTime()
    {
        return $this->post->with('tag')->orderBy('updated_at','DESC')->get();
    }

    public function searchPosts($query)
    {
        $params = [
            'index' => 'posts',
            'type' => 'articles',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'content', 'tags']
                    ]
                ]
            ]
        ];
        return $this->elasticSearch->search($params)['hits']['hits'];
    }

    public function searchSuggest($query)
    {
        $params = [
            'index' => 'posts',
            'type' => 'articles',
            'body' => [
                'suggest' => [
                    'suggestions' => [
                        'text' => $query,
                        'completion' => [
                            'field' => 'suggest',
                            'fuzzy' => [
                                'fuzziness' => 2
                            ]
                        ]
                    ]
                ],
                '_source' => 'title'
            ]
        ];
        return $this->elasticSearch->search($params)['suggest']['suggestions'][0]['options'];
    }

}