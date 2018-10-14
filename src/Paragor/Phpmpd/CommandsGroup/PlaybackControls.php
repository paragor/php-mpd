<?php


namespace Paragor\Phpmpd\CommandsGroup;


/**
 * https://www.musicpd.org/doc/protocol/playback_commands.html
 *
 * Class PlaybackControlling
 * @package Paragor\Phpmpd\CommandsGroup
 */
class PlaybackControls extends AbstractCommandGroup
{
    /**
     * Plays next song in the playlist
     */
    public function next(): void
    {
        $this->client->execute("next");
    }

    /**
     * Toggles pause/resumes playing
     */
    public function pause(): void
    {
        $this->client->execute("pause");
    }

    /**
     * Begins playing the playlist at song number songPosition.
     *
     * @param int $songPosition
     */
    public function play(int $songPosition = null): void
    {
        $this->client->execute("play {$songPosition}");
    }

    /**
     * Begins playing the playlist at song songId.
     *
     * @param int $songId
     */
    public function playId(int $songId = null): void
    {
        $this->client->execute("playid {$songId}");
    }

    /**
     * Plays previous song in the playlist.
     */
    public function previous(): void
    {
        $this->client->execute("previous");
    }

    /**
     * Seeks to the position TIME (in seconds; fractions allowed) of entry songPosition in the playlist.
     *
     * @param int $songPosition
     * @param int $time
     */
    public function seek(int $songPosition, int $time): void
    {
        $this->client->execute("seek {$songPosition} {$time}");
    }

    /**
     * Seeks to the position TIME (in seconds; fractions allowed) of song songId.
     *
     * @param int $songId
     * @param int $time
     */
    public function seekId(int $songId, int $time): void
    {
        $this->client->execute("seek {$songId} {$time}");
    }

    /**
     * Seeks to the position TIME (in seconds; fractions allowed) within the current song.
     * If prefixed by '+' or '-', then the time is relative to the current playing position.
     *
     * @param int $time
     */
    public function seekCur(string $time): void
    {
        $this->client->execute("seekcur {$time}");
    }

    /**
     * Stops playing.
     */
    public function stop(): void
    {
        $this->client->execute("stop");
    }
}