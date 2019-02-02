<?php namespace ss\tm\controllers;

class Events extends \Controller
{
    public $singleton = true;

    private $events;

    public function __create()
    {
        $this->events = &$this->d();
    }

    public function rebindFromHandlers()
    {
        if ($cat = \ewma\handlers\models\Cat::where('path', 'ss/telemetry/events')->first()) {
            $catsIds = \ewma\Data\Tree::getIds($cat);

            $handlers = \ewma\handlers\models\Handler::where('target_type', \ewma\handlers\models\Cat::class)->whereIn('target_id', $catsIds)->get();

            $events = &$this->d();

            $events = [];

            foreach ($handlers as $handler) {
                $eventPath = trim_l_slash(str_replace(['ss/telemetry/events', ':'], ['', '/'], $handler->path));
                $eventData = handlers()->render($handler);

                ap($events, $eventPath, $eventData);
            }
        } else {
            $this->console('handlers cat ss/telemetry/events not exists');
        }
    }

    public function trigger()
    {
        sstm()->events->trigger($this->data('path'), $this->data('data'));
    }
}
