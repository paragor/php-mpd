<?php


namespace Paragor\Phpmpd\CommandsGroup;


/**
 * https://www.musicpd.org/doc/protocol/playback_option_commands.html
 *
 * Class PlaybackOptions
 * @package Paragor\Phpmpd\CommandsGroup
 */
class PlaybackOptions extends AbstractCommandGroup
{
    public const REPLAY_GAIN_MODE_OFF = 'off';
    public const REPLAY_GAIN_MODE_TRACK = 'track';
    public const REPLAY_GAIN_MODE_ALBUM = 'album';
    public const REPLAY_GAIN_MODE_AUTO = 'auto';

    /**
     * Sets consume state to STATE, STATE should be 0 or 1. When consume is activated, each song played is removed from playlist.
     *
     * @param string $state
     */
    public function consume(string $state): void
    {
        $this->client->execute("consume {$state}");
    }

    /**
     * Sets crossfading between songs.
     *
     * @param int $seconds
     */
    public function crossfade(int $seconds): void
    {
        $this->client->execute("crossfade {$seconds}");
    }

    /**
     * Sets the threshold at which songs will be overlapped. Like crossfading but doesn't fade the track volume,
     * just overlaps. The songs need to have MixRamp tags added by an external tool. 0dB is the normalized maximum
     * volume so use negative values, I prefer -17dB. In the absence of mixramp tags crossfading will be used.
     * See http://sourceforge.net/projects/mixramp
     *
     * @param int $deciBels
     */
    public function mixrampdb(int $deciBels): void
    {
        $this->client->execute("mixrampdb {$deciBels}");
    }

    /**
     * Additional time subtracted from the overlap calculated by mixrampdb.
     * A value of "nan" disables MixRamp overlapping and falls back to crossfading.
     *
     * @param int $seconds
     */
    public function mixrampdelay(int $seconds): void
    {
        $this->client->execute("mixrampdelay {$seconds}");
    }

    /**
     * Sets random state to STATE, STATE should be 0 or 1.
     *
     * @param bool $state
     */
    public function random(bool $state): void
    {
        $this->client->execute('random ' . ($state ? 1 : 0));
    }

    /**
     * Sets repeat state to STATE, STATE should be 0 or 1.
     *
     * @param bool $state
     */
    public function repeat(bool $state): void
    {
        $this->client->execute('repeat ' . ($state ? 1 : 0));
    }

    /**
     * Sets volume to VOL, the range of volume is 0-100.
     *
     * @param int $vol
     */
    public function setvol(int $vol): void
    {
        if ($vol > 100) {
            $vol = 100;
        }
        if ($vol < 0) {
            $vol = 0;
        }
        $this->client->execute("setvol {$vol}");
    }


    /**
     * Sets single state to STATE, STATE should be 0 or 1.
     * When single is activated, playback is stopped after current song,
     * or song is repeated if the 'repeat' mode is enabled.
     *
     * @param bool $state
     */
    public function single(bool $state): void
    {
        $this->client->execute('single ' . ($state ? 1 : 0));
    }

    /**
     * Sets the replay gain mode. One of *off*, *track*, *album*, *auto*.
     * Changing the mode during playback may take several seconds,
     * because the new settings does not affect the buffered data.
     * This command triggers the options idle event.
     *
     * @param string $mode
     */
    public function replayGainMode(string $mode): void
    {
        $this->client->execute("replay_gain_mode {$mode}");
    }

    /**
     * Prints replay gain options. Currently, only the variable replay_gain_mode is returned.
     *
     * @return string
     */
    public function replayGainStatus(): string
    {
        $res = $this->client->execute('replay_gain_status');
        return $res->getBody();
    }

    /**
     * Changes volume by amount CHANGE.
     *
     * @deprecated
     * @param int $change
     */
    public function volume(int $change): void
    {
        $this->client->execute("volume {$change}");
    }
}