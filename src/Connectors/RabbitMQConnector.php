<?php

namespace DesignMyNight\Laravel\Horizon\Connectors;

use DesignMyNight\Laravel\Horizon\RabbitMQQueue;
use Enqueue\AmqpTools\DelayStrategyAware;
use Enqueue\AmqpTools\RabbitMqDlxDelayStrategy;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Events\WorkerStopping;
use Illuminate\Support\Arr;
use Interop\Amqp\AmqpConnectionFactory;
use Interop\Amqp\AmqpContext;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector as BaseConnector;

class RabbitMQConnector extends BaseConnector
{
    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(array $config): Queue
    {
        $connection = $this->createConnection(Arr::except($config, 'options.queue'));

        return new RabbitMQQueue(
          $connection,
          $config['queue'],
          $config);
    }
}
