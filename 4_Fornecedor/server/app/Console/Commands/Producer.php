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
    protected $description = 'Produz dados para um servidor Kafka';

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
        //Contagem do tempo de início da produção
        $start = \microtime(true);
        $count = 0;

        //Dados do tipo de fornecedor
        foreach(TipoFornecedor::all() as $key => $obj):
            $obj['type'] = 'supplier_type';
            $message = $obj;
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Dados das pessoas (jurídicas)
        foreach(Pessoa::all() as $key => $obj):
            $obj['type'] = 'person';
            $message = $obj;
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Dados dos fornecedores
        foreach(Fornecedor::all() as $key => $obj):
            $obj['type'] = 'supplier';
            $message = $obj;
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Dados das classes terapêuticas
        foreach(ClasseTerapeutica::all() as $key => $obj):
            $obj['type'] = 'therapeutic_class';
            $message = $obj;
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Dados dos tipos de produto
        foreach(TipoProduto::all() as $key => $obj):
            $obj['type'] = 'product_type';
            $message = $obj;
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Dados das tarjas de medicamento
        foreach(Tarja::all() as $key => $obj): 
            $obj['type'] = 'stripe';
            $message = $obj;  
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Dados dos medicamentos
        foreach(Medicamento::all() as $key => $obj):
            $obj['type'] = 'medicine';
            $message = $obj;
            $count++;
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        endforeach;

        //Contagem do tempo de fim da produção
        $duration = \microtime(true) - $start;
        echo "{$count} mensagens produzidas em {$duration} segundos" . PHP_EOL;
    }
}
