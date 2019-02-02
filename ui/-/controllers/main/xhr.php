<?php namespace ss\tm\ui\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function reload()
    {
        $this->c('~:reload');
    }
}
