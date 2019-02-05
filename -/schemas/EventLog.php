<?php namespace ss\tm\schemas;

class EventLog extends \Schema
{
    public $table = 'ss_tm_events';

    public function blueprint()
    {
        return function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->char('session_key', 32)->default('');
            $table->char('ip', 15)->default('');
            $table->string('tab')->default('');
            $table->bigInteger('microtime')->default(0)->unsigned();
            $table->enum('device', ['desktop', 'tablet', 'mobile'])->default('desktop');
            $table->string('path')->default('');
            $table->text('data');
            $table->text('triggers_output');
            $table->mediumText('request_headers');
        };
    }
}
