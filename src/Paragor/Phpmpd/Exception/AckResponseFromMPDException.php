<?php


namespace Paragor\Phpmpd\Exception;


class AckResponseFromMPDException extends PhpmpdException
{
    protected $rowResponse;
    protected $error;
    protected $commandListNum;
    protected $currentCommand;
    protected $messageText;

    public function __construct(string $rowResponse)
    {
        $matches = [];
        $pattern = '/ACK \[([0-9]+)@([0-9])+\] \{([^}]*)\} (.+)/';
        $isMatch = preg_match($pattern, $rowResponse, $matches);
        if ($isMatch) {
            $this->error = intval($matches[1]);
            $this->commandListNum = intval($matches[2]);
            $this->currentCommand = $matches[3];
            $this->messageText = $matches[4];
        }
        parent::__construct("Ack response from MPD: $rowResponse");
    }

    public function getRowResponse(): string
    {
        return $this->rowResponse;
    }

    /**
     * Numeric value of one of the ACK_ERROR constants defined in src/protocol/Ack.hxx.
     *
     * @return int
     */
    public function getError(): int
    {
        return $this->error;

    }

    /**
     * Offset of the command that caused the error in a [Command List](https://www.musicpd.org/doc/protocol/command_lists.html)
     * An error will always cause a command list to terminate at the command that causes the error
     *
     * @return int
     */
    public function getCommandListNum(): int
    {
        return $this->commandListNum;

    }

    /**
     * Name of the command, in a [Command List](https://www.musicpd.org/doc/protocol/command_lists.html),
     * that was executing when the error occurred.
     *
     * @return string
     */
    public function getCurrentCommand(): string
    {
        return $this->currentCommand;
    }

    /**
     * Some (hopefully) informative text that describes the nature of the error.
     *
     * @return string
     */
    public function getMessageText(): string
    {

        return $this->messageText;

    }
}