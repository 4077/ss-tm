<?php namespace ss\tm\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function hd()
    {
        $tab = $this->app->tab;

        if ($eventRecord = $this->unxpackModel('e')) {
            if (!$eventRecord->tab) {
                $eventRecord->tab = $tab;
                $eventRecord->save();
            }

            $eventRecord->humandata()->create([
                                                  'microtime' => microtime(true),
                                                  'data'      => j_($this->data('hd'))
                                              ]);
        }
    }

    public function gd()
    {
        $data = $this->data('meta');

        \ss\tm\models\GeodataYmaps::create([
                                               'session_key' => $this->app->session->getKey(),
                                               'ip'          => $_SERVER['HTTP_X_FORWARDED_FOR'],
                                               'datetime'    => \Carbon\Carbon::now()->toDateTimeString(),
                                               'data'        => j_($data)
                                           ]);
    }
}
