<?php namespace ss\tm\ui\controllers\main;

class EventInfo extends \Controller
{
    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $record = $this->unpackModel('record');

        $headers = _j($record->request_headers);

        if ($userId = $record->user_id and $user = \ss\models\User::find($userId)) {
            $v->assign('user', [
                'LOGIN' => $user->login
            ]);
        }

        $device = false;
        $browserName = false;
        $browserVersion = false;

        $userAgentHeader = $headers['user-agent'] ?? [''];

        $userAgent = end($userAgentHeader);

        if ($userAgent) {
            $detect = new \Mobile_Detect;

            $detect->setUserAgent($userAgent);

            if ($detect->isTablet()) {
                $device = 'tablet';
            } elseif ($detect->isMobile()) {
                $device = 'mobile';
            } else {
                $device = 'desktop';
            }
        }

        $referer = false;
        if (isset($headers['referer'])) {
            $referer = urldecode(end($headers['referer']));
        }

        $v->assign([
                       'SESSION_KEY' => $record->session_key,
                       'IP'          => $record->ip,
                       'REFERER'     => $referer,
                       'USER_AGENT'  => $userAgent ?: '-',
                       'DEVICE'      => $device ?: '-'
                   ]);

        $this->css();

        return $v;
    }
}
