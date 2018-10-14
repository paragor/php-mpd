<?php

namespace Tests\Paragor\Phpmpd\Exception;

use Paragor\Phpmpd\Exception\AckResponseFromMPDException;

class AckResponseFromMPDExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testGetCommandListNum()
    {
        $response = 'ACK [50@1] {play} song doesn\'t exist: "10240"';
        $ack = new AckResponseFromMPDException($response);
        $this->assertEquals(1, $ack->getCommandListNum());

    }

    public function testGetError()
    {
        $response = 'ACK [50@1] {play} song doesn\'t exist: "10240"';
        $ack = new AckResponseFromMPDException($response);
        $this->assertEquals(50, $ack->getError());
    }

    public function testGetCurrentCommand()
    {
        $response = 'ACK [50@1] {play} song doesn\'t exist: "10240"';
        $ack = new AckResponseFromMPDException($response);
        $this->assertEquals('play', $ack->getCurrentCommand());

    }

    public function testGetMessageText()
    {
        $response = 'ACK [50@1] {play} song doesn\'t exist: "10240"';
        $ack = new AckResponseFromMPDException($response);
        $this->assertEquals('song doesn\'t exist: "10240"', $ack->getMessageText());

    }

}
