<?php


namespace Paragor\Phpmpd\Client;


interface ClientInterface
{
    public function execute(string $cmd): Response;

}