<?php namespace ss\tm\controllers;

class Main extends \Controller
{
    public $singleton = true;

    public function humanMonitor($eventRecord)
    {
        $this->addToPage();

        $this->widget(':', 'option', 'e', xpack_model($eventRecord));
        $this->widget(':', 'hm');
    }

    public function ymaps()
    {
        $ymapsGeodata = \ss\tm\models\GeodataYmaps::where('session_key', $this->app->session->getKey())
            ->where('ip', $_SERVER['HTTP_X_FORWARDED_FOR'])
            ->orderBy('datetime', 'DESC')
            ->first();

        if (!$ymapsGeodata) {
            $this->addToPage();

            $this->widget(':', 'gm', [
                'src' => 'https://api-maps.yandex.ru/2.1/?apikey=9cb7d6c4-c149-45c5-9907-0a62459fc4ff&lang=ru_RU' // todo cfg
            ]);
        }
    }

    private $addedToPage;

    private function addToPage()
    {
        if (!$this->addedToPage) {
            $this->app->html->addContainer('ss_tm', $this->v());

            $this->widget(':', [
                'e'  => false,
                '.r' => [
                    'hd' => $this->_p('>xhr:hd'),
                    'gd' => $this->_p('>xhr:gd')
                ]
            ]);

            $this->addedToPage = true;
        }
    }
}
