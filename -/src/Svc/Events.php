<?php namespace ss\tm\Svc;

class Events extends \ewma\Service\Service
{
    protected $services = ['svc', 'log'];

    /**
     * @var \ss\tm\Svc
     */
    public $svc = \ss\tm\Svc::class;

    /**
     * @var \ss\tm\Svc\Events\Log
     */
    public $log = \ss\tm\Svc\Events\Log::class;

    //
    //
    //

    private $eventsData;

    protected function boot()
    {
        $this->eventsData = &$this->svc->eventsController->d();
    }

    public function &getData()
    {
        return $this->eventsData;
    }

    public function trigger($path, $data = [])
    {
        if ($event = ap($this->eventsData, $path)) {
            $mainController = $this->svc->mainController;

            $triggersOutput = [];

            $data = pack_models($data);

            if ($triggers = ap($event, 'triggers')) {
                foreach ($triggers as $triggerName => $triggerData) {
                    if ($triggerData['enabled'] && $triggerCall = $triggerData['call']) {
                        $triggersOutput[$triggerName] = $mainController->_call($mainController->_abs($triggerCall))->ra($data)->perform();
                    }
                }
            }

            $eventRecord = false;
            if (ap($event, 'log/enabled')) {
                $eventRecord = $this->log->write($path, $data, $triggersOutput);
            }

            if (ap($event, 'human_monitor')) {
                $mainController->humanMonitor($eventRecord);
            }

            if (in('ymaps', ap($event, 'geodata'))) {
                $mainController->ymaps();
            }
        }
    }

    private $eventsInfo = [];

    /**
     * @param \ss\tm\models\EventLog $eventRecord
     *
     * @return \ss\tm\Svc\Events\EventInfo
     */
    public function getEventInfo(\ss\tm\models\EventLog $eventRecord)
    {
        if (!isset($this->eventsInfo[$eventRecord->id])) {
            $this->eventsInfo[$eventRecord->id] = new \ss\tm\Svc\Events\EventInfo($eventRecord);
        }

        return $this->eventsInfo[$eventRecord->id];
    }
}
