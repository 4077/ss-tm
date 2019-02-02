<?php namespace ss\tm\Svc\Clients;

class ClientInfo
{
    private $sessionKey;

    private $user;

    public function __construct($sessionKey)
    {
        $this->sessionKey = $sessionKey;

        $this->user = \ewma\access\models\User::where('session_key', $sessionKey)->first();

        $this->loadCache();

        app()->events->bind('app/terminate', function () {
            $this->updateCache();
        });
    }

    public function isUser()
    {
        return $this->user ? true : false;
    }

    public function getName($trimSessionKey = false)
    {
        return $this->user ? $this->user->login : ($trimSessionKey ? substr($this->sessionKey, 0, 8) . '...' : $this->sessionKey);
    }

    //
    // humandata
    //

    private $isHuman;

    public function isHuman()
    {
        if (null === $this->isHuman) {
            $eventRecords = \ss\tm\models\EventLog::where('session_key', $this->sessionKey)->get();

            $humanActionsCount = \ss\tm\models\EventHumandata::whereIn('event_id', table_ids($eventRecords))->count();

            $this->isHuman = $humanActionsCount ? true : false;
        }

        return $this->isHuman;
    }

    //
    // geodata
    //

    private $city;

    public function getCity()
    {
        if (null === $this->city) {
            if ($ymapsGeodata = $this->getYmapsGeodata()) {
                $data = _j($ymapsGeodata->data);

                $addressComponents = ap($data, 'GeocoderMetaData/Address/Components');

                $lastAddressComponent = end($addressComponents);

                $this->city = $lastAddressComponent['name'];
            }
        }

        return $this->city;
    }

    private $ymapsGeodata;

    public function getYmapsGeodata()
    {
        if (null === $this->ymapsGeodata) {
            $this->ymapsGeodata = \ss\tm\models\GeodataYmaps::where('session_key', $this->sessionKey)->orderBy('datetime', 'DESC')->first();
        }

        return $this->ymapsGeodata;
    }

    //
    // avatar
    //

    private $avatarsCache = [];

    public function getAvatarSrc($md5)
    {
        if (!isset($this->avatarsCache[$md5])) {
            $this->avatarsCache[$md5] = $this->renderAvatar($md5);
        }

        return $this->avatarsCache[$md5];
    }

    private function loadCache()
    {
        $avatarsCacheFilePath = sstm()->mainController->_protected('cache', 'rendered_avatars.php');

        if (!file_exists($avatarsCacheFilePath)) {
            awrite($avatarsCacheFilePath);
        }

        $this->avatarsCache = aread($avatarsCacheFilePath);
    }

    private function updateCache()
    {
        $avatarsCacheFilePath = sstm()->mainController->_protected('cache', 'rendered_avatars.php');

        awrite($avatarsCacheFilePath, $this->avatarsCache);
    }

    private function renderAvatar($md5)
    {
        $size = 1000;

        $image = \Intervention\Image\ImageManagerStatic::canvas($size, $size);

        $radius = 1000;

        for ($n = 0; $n < 5; $n++) {
            $image->circle($radius, 500, 500, function ($draw) use ($md5, $n) {
                $draw->background('#' . substr($md5, $n * 3, 6));
            });

            $radius -= 200;
        }

        return $image->resize(21, 21)->encode('data-url')->encoded;
    }
}
