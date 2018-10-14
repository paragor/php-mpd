<?php


namespace Paragor\Phpmpd\Client;


use Paragor\Phpmpd\Exception\ConnectionFailedException;

class SocketClient implements ClientInterface
{
    protected $socket;
    protected $errorNo;
    protected $errorStr;

    public function __construct(string $host, int $port = 6600, int $timeout = 10)
    {
        $this->socket = fsockopen($host, $port, $this->errorNo, $this->errorStr, $timeout);
        if (!$this->socket) {
            throw new ConnectionFailedException($this->prepareErrorString());
        }
        $body = $this->getBody();
        if (!preg_match('/^OK/', $body)) {
            throw new ConnectionFailedException("Bad response from MPD: {$body}");
        }
    }

    public function execute(string $cmd): Response
    {
        fputs($this->socket, $cmd . "\n");
        return new Response($this->getBody());
    }

    public function getBody(): string
    {
        $out = '';
        while (!feof($this->socket)) {
            $str = fgets($this->socket, 1024);
            $out .= $str;
            if (preg_match('/^(OK)|(ACK)/', $str)) {
                break;
            }
        }
        return $out;
    }

    protected function prepareErrorString()
    {
        return "Error #{$this->errorNo}: {$this->errorStr}";
    }

    public function __destruct()
    {
        fclose($this->socket);
    }
}