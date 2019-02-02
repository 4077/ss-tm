<?php namespace ss\tm\Svc;

class Clients extends \ewma\Service\Service
{
    protected $services = ['svc'];

    /**
     * @var \ss\tm\Svc
     */
    public $svc = \ss\tm\Svc::class;

    //
    //
    //

    private $clientsInfo = [];

    /**
     * @param $sessionKey
     *
     * @return \ss\tm\Svc\Clients\ClientInfo
     */
    public function getClientInfo($sessionKey)
    {
        if (!isset($this->clientsInfo[$sessionKey])) {
            $this->clientsInfo[$sessionKey] = new \ss\tm\Svc\Clients\ClientInfo($sessionKey);
        }

        return $this->clientsInfo[$sessionKey];
    }
}
