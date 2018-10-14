<?php


namespace Paragor\Phpmpd\Client;


use Paragor\Phpmpd\Exception\AckResponseFromMPDException;
use Paragor\Phpmpd\Exception\PhpmpdException;

class Response
{
    protected $isSuccess;
    protected $body;

    public function __construct(string $rowResponse)
    {
        $this->parseResponse($rowResponse);
    }

    protected function parseResponse(string $rowResponse)
    {
        $status = $this->parseStatus($rowResponse);
        if (!($this->isSuccess = ($status == 'OK'))) {
            throw new AckResponseFromMPDException($rowResponse);
        }
        $withoutStatusStringPattern = '/[^\n]+\n$/';
        $this->body = preg_replace($withoutStatusStringPattern, '', $rowResponse);
    }

    public function getBody(): string
   {
        return $this->body;
    }

    protected function parseStatus(string $rowResponse): string
    {
        $lines = explode("\n", trim($rowResponse));
        $statusString = array_pop($lines);
        if (!preg_match('/^(OK|ACK)/', $statusString, $matches)) {
            throw new PhpmpdException('Can\'t parse MPD response:' . $rowResponse);
        }
        return $matches[1];
    }

}