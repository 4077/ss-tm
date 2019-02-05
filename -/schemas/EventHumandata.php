<?php namespace ss\tm\schemas;

class EventHumandata extends \Schema
{
    public $table = 'ss_tm_events_humandata';

    public function blueprint()
    {
        return function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('event_id')->default(0)->unsigned();
            $table->bigInteger('microtime')->default(0)->unsigned();
            $table->mediumText('data');
        };
    }
}
