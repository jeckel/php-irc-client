<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 12/01/2023
 */

declare(strict_types=1);

namespace Jerodev\PhpIrcClient\Messages;

use Jerodev\PhpIrcClient\Helpers\Event;

class WhoisChannelsMessage extends IrcMessage
{
    /** @var string */
    protected $nick;

    /** @var string[] */
    protected $channels = [];

    public function __construct(string $message)
    {
        parent::__construct($message);

        $suffix = explode(' ', $this->commandSuffix() ?? ' ');
        $this->nick = $suffix[1];
        $this->channels = explode(' ', $this->payload);
    }

    public function getEvents(): array
    {
        return [
            new Event(
                Event::WHOIS_CHANNELS,
                [
                    'nick' => $this->nick,
                    'channels' => $this->channels,
                ]
            ),
        ];
    }
}
