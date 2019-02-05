<?php namespace ss\tm\schemas;

class GeodataYmaps extends \Schema
{
    public $table = 'ss_tm_geodata_ymaps';

    public function blueprint()
    {
        return function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->char('session_key', 32)->default('');
            $table->char('ip', 15)->default('');
            $table->dateTime('datetime');
            $table->text('data');
        };
    }
}
