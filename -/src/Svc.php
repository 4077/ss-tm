<?php namespace ss\tm;

class Svc extends \ewma\Service\Service
{
    /**
     * @var self
     */
    public static $instance;

    /**
     * @return \ss\tm\Svc
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            $svc = new self;

            static::$instance = $svc;
            static::$instance->__register__();
        }

        return static::$instance;
    }

    protected $services = [
        'events',
        'eventLog',
        'clients'
    ];

    /**
     * @var \ss\tm\Svc\Events
     */
    public $events = \ss\tm\Svc\Events::class;

    /**
     * @var \ss\tm\Svc\Log
     */
    public $eventLog = \ss\tm\Svc\Log::class;

    /**
     * @var \ss\tm\Svc\Clients
     */
    public $clients = \ss\tm\Svc\Clients::class;

    //
    //
    //

    /**
     * @var \ss\tm\controllers\Main
     */
    public $mainController;

    /**
     * @var \ss\tm\controllers\Events
     */
    public $eventsController;

    protected function boot()
    {
        $this->mainController = appc('\ss\tm~');
        $this->eventsController = appc('\ss\tm events');
    }
}
