<?php


namespace Paragor\Phpmpd\CommandsGroup;


use Paragor\Phpmpd\Client\ClientInterface;

abstract class AbstractCommandGroup
{
    protected $client;
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
}