<?php namespace ss\tm\models;

class EventLog extends \Model
{
    public $table = 'ss_tm_events';

    public function humandata()
    {
        return $this->hasMany(EventHumandata::class, 'event_id');
    }
}
