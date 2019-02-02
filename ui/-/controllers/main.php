<?php namespace ss\tm\ui\controllers;

class Main extends \Controller
{
    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        pusher()->subscribe();

        $v = $this->v('|');

        $this->css();

        $this->widget(':|', [
            '.r' => [

            ]
        ]);

        return $v;
    }
}
