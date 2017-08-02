<?php
namespace App\Services;

/**
 * All methods(except *exists) returns false on error,
 * so one should use Identical(if($ret === false)) to test the return value.
 */
class KafkaService
{

    public static function produce($data)
    {
        $config = \Kafka\ProducerConfig::getInstance();
        $config->setMetadataBrokerList(config('app.kafka_hosts'));
        $config->setBrokerVersion(config('app.kafka_version'));
        $queryBuilder = [];
        if(is_array($data)){
            foreach ($data as $key => $value) {
                $queryBuilder[] = [
                    'topic' => 'posts',
                    'value' => $value,
                ];
            }
        }
        $producer = new \Kafka\Producer(function() use ($queryBuilder) {
            return $queryBuilder;
        });
        $producer->send(true);
    }
}