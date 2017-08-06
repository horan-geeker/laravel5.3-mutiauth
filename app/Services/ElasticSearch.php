<?php
namespace App\Services;

use Elasticsearch\ClientBuilder;

/**
 * All methods(except *exists) returns false on error,
 * so one should use Identical(if($ret === false)) to test the return value.
 */
class ElasticSearch
{

    private $client;

    public function __construct(ClientBuilder $builder)
    {
        $builder = ClientBuilder::create();
        $builder->setHosts(config('app.elastic_search'));
        $this->client = $builder->build();
    }

    public function search($query)
    {
        return $this->client->search($query);
    }

    public function insert($data)
    {
        return $this->client->index();
    }
}