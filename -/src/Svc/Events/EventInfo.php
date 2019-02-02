<?php namespace ss\tm\Svc\Events;

class EventInfo
{
    private $record;

    private $sessionKey;

    private $eventsData;

    public function __construct($record)
    {
        $this->record = $record;
        $this->sessionKey = $record->session_key;

        $this->eventsData = sstm()->events->getData();

        $this->render();
    }

    public function getClientInfo()
    {
        return sstm()->clients->getClientInfo($this->sessionKey);
    }

    public $icon;

    public $name;

    public $class;

    public $desc;

    private function render()
    {
        if ($eventData = ap($this->eventsData, $this->record->path)) {
            $this->icon = $eventData['icon'] ?? false;
            $this->name = $eventData['name'] ?? '';
            $this->class = $eventData['class'] ?? '';

            if ($descCall = $eventData['log']['calls']['desc']) {
                $this->desc = appc()->_call(appc()->_abs($descCall))->ra(_j($this->record->data))->perform();
            }
        }
    }

    //
    // humandata
    //

    public function getHumandata()
    {
        $humandataRecords = $this->record->humandata()->orderBy('microtime')->get();
    }


}
