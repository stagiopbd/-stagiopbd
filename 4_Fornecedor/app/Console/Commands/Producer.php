<?php

namespace App\Console\Commands;

use App\Fornecedor;
use App\Medicamento;
use App\Pessoa;
use App\ClasseTerapeutica;
use App\Tarja;
use App\TipoFornecedor;
use App\TipoProduto;

use Illuminate\Console\Command;

class Producer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'producer-kafka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Produces data for Kafka Server';

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
        $producer = new \RdKafka\Producer();
        $producer->setLogLevel(LOG_DEBUG);
        $producer->addBrokers("kafka:9093");
        $topic = $producer->newTopic("det-fornecedor");

        //Time start
        $start = \microtime(true);
        $count = 0;

        foreach(TipoFornecedor::all() as $key => $obj):
            $obj['type'] = 'supplier_type';
            $message =  $key . ' ' . $obj;
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        foreach(Pessoa::all() as $key => $obj):
            $obj['type'] = 'person';
            $message =  $key . ' ' . $obj;
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        foreach(Fornecedor::all() as $key => $obj):
            $obj['type'] = 'supplier';
            $message =  $key . ' ' . $obj;
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        foreach(ClasseTerapeutica::all() as $key => $obj):
            $obj['type'] = 'therapeutic_class';
            $message =  $key . ' ' . $obj;
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        foreach(TipoProduto::all() as $key => $obj):
            $obj['type'] = 'product_type';
            $message =  $key . ' ' . $obj;
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        foreach(Tarja::all() as $key => $obj): 
            $obj['type'] = 'stripe';
            $message =  $key . ' ' . $obj;  
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        foreach(Medicamento::all() as $key => $obj):
            $obj['type'] = 'medicine';
            $message =  $key . ' ' . $obj;
            echo $obj;

            $count++;
            echo "\n----------\n";

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        $duration = \microtime(true) - $start;

        echo "Produced {$count} messages in {$duration} seconds" . PHP_EOL;
    }
}
