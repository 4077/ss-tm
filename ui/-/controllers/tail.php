<?php namespace ss\tm\ui\controllers;

class Tail extends \Controller
{
    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        pusher()->subscribe();

        $v = $this->v('|');

        $s = &$this->s(false, [
            'last_record_id' => false
        ]);

        $length = $this->data('length') or
        $length = 50;

        $records = \ss\tm\models\EventLog::orderBy('microtime', 'DESC')->take($length)->get();

        $s['last_record_id'] = $records[0]->id ?? false;

        foreach ($records as $record) {
            $v->assign('record', [
                'CONTENT' => $this->c('>record:view|', ['record' => $record])
            ]);
        }

        $this->css(':classes');

        $this->widget(':|', [
            '.r'    => [
                'reload'         => $this->_p('>xhr:reload|'),
                'loadNewRecords' => $this->_p('>xhr:loadNewRecords|'),
                'eventInfo'      => $this->_p('>xhr:eventInfo')
            ],
            'envId' => $this->_env()
        ]);

        $this->c('\std\ui\dialogs~:addContainer:ss/tm');

        return $v;
    }
}
