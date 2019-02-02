<?php namespace ss\tm\Svc\Events;

class Log extends \ewma\Service\Service
{
    public function write($path, $data = [], $triggersOutput = [])
    {
        $app = app();

        $user = $app->c()->_user();
        $sessionKey = $app->session->getKey();

        $detect = new \Mobile_Detect;

        if ($detect->isTablet()) {
            $device = 'tablet';
        } elseif ($detect->isMobile()) {
            $device = 'mobile';
        } else {
            $device = 'desktop';
        }

        $headers = $app->request->headers->all();

        $record = \ss\tm\models\EventLog::create([
                                                     'user_id'         => $user->model->id ?? null,
                                                     'session_key'     => $sessionKey,
                                                     'ip'              => $headers['http-x-forwarded-for'][0] ?? '',
                                                     'tab'             => $app->tab ?? '',
                                                     'datetime'        => \Carbon\Carbon::now()->toDateTimeString(),
                                                     'microtime'       => microtime(true) * 10000,
                                                     'device'          => $device,
                                                     'path'            => $path,
                                                     'data'            => j_($data),
                                                     'triggers_output' => j_($triggersOutput),
                                                     'request_headers' => j_($headers)
                                                 ]);

        pusher()->trigger('ss/tm/eventRecord', [
            'envId'      => app()->getEnv(),
            'sessionKey' => $sessionKey,
            'recordId'   => $record->id
        ]);

        return $record;
    }
}
