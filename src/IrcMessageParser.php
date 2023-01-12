<?php

namespace Jerodev\PhpIrcClient;

use Generator;
use Jerodev\PhpIrcClient\Messages\IrcMessage;
use Jerodev\PhpIrcClient\Messages\JoinMessage;
use Jerodev\PhpIrcClient\Messages\KickMessage;
use Jerodev\PhpIrcClient\Messages\MOTDMessage;
use Jerodev\PhpIrcClient\Messages\NameReplyMessage;
use Jerodev\PhpIrcClient\Messages\PingMessage;
use Jerodev\PhpIrcClient\Messages\PrivmsgMessage;
use Jerodev\PhpIrcClient\Messages\TopicChangeMessage;
use Jerodev\PhpIrcClient\Messages\WelcomeMessage;
use Jerodev\PhpIrcClient\Messages\WhoisChannelsMessage;
use Jerodev\PhpIrcClient\Messages\WhoisMessage;

class IrcMessageParser
{
    /**
     *  Parse one ore more irc messages.
     *
     *  @param string $message A string received from the irc server
     *
     *  @return Generator|IrcMessage[]
     */
    public function parse(string $message)
    {
        foreach (explode("\n", $message) as $msg) {
            if (empty(trim($msg))) {
                continue;
            }

            yield $this->parseSingle($msg);
        }
    }

    /**
     *  Parse a single message to a corresponding object.
     *
     *  @param string $message
     *
     *  @return IrcMessage
     */
    private function parseSingle(string $message): IrcMessage
    {
        switch ($this->getCommand($message)) {
            case 'KICK':
                return new KickMessage($message);
            case 'PING':
                return new PingMessage($message);
            case 'PRIVMSG':
                return new PrivmsgMessage($message);
            case IrcCommand::RPL_WELCOME:
                return new WelcomeMessage($message);
            case IrcCommand::RPL_WHOISUSER:
                return new WhoisMessage($message);
            case IrcCommand::RPL_WHOISCHANNELS:
                return new WhoisChannelsMessage($message);
            case 'TOPIC':
            case IrcCommand::RPL_TOPIC:
                return new TopicChangeMessage($message);
            case IrcCommand::RPL_NAMREPLY:
                return new NameReplyMessage($message);
            case IrcCommand::RPL_MOTD:
                return new MOTDMessage($message);
            case 'JOIN':
                return new JoinMessage($message);
            default:
                return new IrcMessage($message);
        }
    }

    /**
     *  Get the COMMAND part of an irc message.
     *
     *  @param string $message a raw irc message
     *
     *  @return string
     */
    private function getCommand(string $message): string
    {
        if ($message[0] === ':') {
            $message = trim(strstr($message, ' '));
        }

        return strstr($message, ' ', true);
    }
}
