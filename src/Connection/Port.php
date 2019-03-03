<?php

namespace Mcustiel\Phiremock\Client\Connection;

class Port
{
    /** @var int */
    private $port;

    /**
     * @param int $port
     */
    public function __construct($port)
    {
        $this->ensureIsValidPort($port);
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->port;
    }

    private function ensureIsValidPort($port)
    {
        if (!\is_int($port)) {
            throw new \InvalidArgumentException('Port must be an integer value');
        }
        if ($port < 1 || $port > 65535) {
            throw new \InvalidArgumentException(sprintf('Invalid port number: %d', $port));
        }
    }
}
