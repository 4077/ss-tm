<?php namespace ss\tm\ui\controllers\tail;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function loadNewRecords()
    {
        if ($lastRecordId = &$this->s('<:last_record_id')) {
            $records = \ss\tm\models\EventLog::where('id', '>', $lastRecordId)->orderBy('id')->get();

            if (count($records)) {
                $prependContent = '';

                foreach ($records as $record) {
                    $prependContent .= $this->c('@record:view', ['record' => $record])->render();

                    $lastRecordId = $record->id;
                }

                $this->jquery('<:|')->find(".records")->prepend($prependContent);
                $this->widget('<:|', 'bindRecords', table_ids($records));
            }
        }
    }

    public function eventInfo()
    {
        if ($record = \ss\tm\models\EventLog::find($this->data('record_id'))) {
            $this->c('\std\ui\dialogs~:open:eventInfo, ss|ss/tm', [
                'path' => '~eventInfo:view',
                'data' => [
                    'record' => pack_model($record)
                ]
            ]);
        }
    }
}
