<?php namespace ss\tm\ui\controllers\tail;

class Record extends \Controller
{
    public function view()
    {
        $v = $this->v();

        $record = $this->data('record');

        $eventInfo = sstm()->events->getEventInfo($record);
        $clientInfo = $eventInfo->getClientInfo();

        $isHuman = $clientInfo->isHuman();

        $v->assign([
                       'ID'                => $record->id,
                       'CLASS'             => $eventInfo->class,
                       'IS_HUMAN_CLASS'    => $isHuman ? 'is_human' : '',
                       'AVATAR_SRC'        => $clientInfo->getAvatarSrc($record->session_key),
                       'DATETIME'          => \Carbon\Carbon::parse($record->datetime)->format('d.m.Y H:i:s'),
                       'CLIENT_CLASS'      => $clientInfo->isUser() ? 'user' : 'guest',
                       'CLIENT_NAME'       => $clientInfo->getName(true),
                       'CLIENT_CITY'       => $clientInfo->getCity(),
                       'DEVICE_ICON_CLASS' => 'fa fa-' . $record->device,
                       'EVENT_ICON_CLASS'  => $eventInfo->icon ? 'fa fa-' . $eventInfo->icon : '',
                       'EVENT_NAME'        => $eventInfo->name,
                       'EVENT_DESC'        => $eventInfo->desc
                   ]);

//        if ($isHuman) {
//            $this->widget('<:|', 'drawHumandata', $eventInfo->getHumandata());
//        }

        return $v;
    }
}
