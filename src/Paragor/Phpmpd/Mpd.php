<?php


namespace Paragor\Phpmpd;


use Paragor\Phpmpd\Client\ClientInterface;
use Paragor\Phpmpd\CommandsGroup\PlaybackControls;
use Paragor\Phpmpd\CommandsGroup\PlaybackOptions;

class Mpd
{
    protected $client;
    protected $playbackOptions;
    protected $playbackControls;


    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->playbackOptions = new PlaybackOptions($client);
        $this->playbackControls = new PlaybackControls($client);
    }

    public function playbackOptions(): PlaybackOptions
    {
        return $this->playbackOptions;
    }

    public function playbackControls(): PlaybackControls
    {
        return $this->playbackControls;
    }

}