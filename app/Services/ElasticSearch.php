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
        $builder->setHosts(['115.28.82.133:9200','115.28.82.133:9201']);
        $this->client = $builder->build();
    }

    public function search($query)
    {
        return $this->client->search($query)['hits']['hits'];
    }

    public function insert($data)
    {
        return $this->client->index();
    }
}