<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SSDB\SimpleSSDB;
use App\Services\SSDB\SSDB;

class SSDBTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SSDBTest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->processTask();
    }

    public function processTask()
    {
        $host = '127.0.0.1';
        $port = 8888;
        try{
            $ssdb = new SimpleSSDB($host, $port);
            //$ssdb->easy();
        }catch(\Exception $e){
            die(__LINE__ . ' ' . $e->getMessage());
        }

        var_dump($ssdb->set('test', time()));
        var_dump($ssdb->set('test', time()));
        echo $ssdb->get('test') . "\n";
        var_dump($ssdb->del('test'));
        var_dump($ssdb->del('test'));
        var_dump($ssdb->get('test'));
        echo "\n";

        var_dump($ssdb->hset('test', 'b', time()));
        var_dump($ssdb->hset('test', 'b', time()));
        echo $ssdb->hget('test', 'b') . "\n";
        var_dump($ssdb->hdel('test', 'b'));
        var_dump($ssdb->hdel('test', 'b'));
        var_dump($ssdb->hget('test', 'b'));
        echo "\n";

        var_dump($ssdb->zset('test', 'a', time()));
        var_dump($ssdb->zset('test', 'a', time()));
        echo $ssdb->zget('test', 'a') . "\n";
        var_dump($ssdb->zdel('test', 'a'));
        var_dump($ssdb->zdel('test', 'a'));
        var_dump($ssdb->zget('test', 'a'));
        echo "\n";

        $ssdb->close();

//        die();

        function speed($msg=null, $count=0){
            static $stime;
            if(!$msg && !$count){
                $stime = microtime(1);
            }else{
                $etime = microtime(1);
                $ts = ($etime - $stime == 0)? 1 : $etime - $stime;
                $speed = $count / floatval($ts);
                $speed = sprintf('%.2f', $speed);
                echo "$msg: " . $speed . "\n";

                $stime = $etime;
            }
        }

        /* a simple bench mark */

        $data = array();
        for($i=0; $i<1000; $i++){
            $k = '' . mt_rand(0, 100000);
            $v = mt_rand(100000, 100000 * 10 - 1) . '';
            $data[$k] = $v;
        }

        speed();
        try{
            $ssdb = new SSDB($host, $port);
        }catch(\Exception $e){
            die(__LINE__ . ' ' . $e->getMessage());
        }
        foreach($data as $k=>$v){
            $ret = $ssdb->set($k, $v);
            if($ret === false){
                echo "error\n";
                break;
            }
        }
        $ssdb->close();
        speed('set speed: ', count($data));


        speed();
        try{
            $ssdb = new SSDB($host, $port);
        }catch(\Exception $e){
            die(__LINE__ . ' ' . $e->getMessage());
        }
        foreach($data as $k=>$v){
            $ret = $ssdb->get($k);
            if($ret === false){
                echo "error\n";
                break;
            }
        }
        $ssdb->close();
        speed('get speed: ', count($data));

    }
}
