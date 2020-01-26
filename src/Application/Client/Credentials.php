<?php

namespace SuperMetrics\Application\Client;

class Credentials
{
    private $clientId;

    private $clientEmail;

    private $clientName;

    public function __construct($clientId = "", $clientEmail = "", $clientName = "")
    {
        $this->clientId = $clientId;
        $this->clientEmail = $clientEmail;
        $this->clientName = $clientName;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }
}
