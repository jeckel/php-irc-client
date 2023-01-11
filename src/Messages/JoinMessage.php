<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 11/01/2023
 */

declare(strict_types=1);

namespace Jerodev\PhpIrcClient\Messages;

use Jerodev\PhpIrcClient\Helpers\Event;

class JoinMessage extends IrcMessage
{
    /** @var string */
    private $nick;

    public function __construct(string $message)
    {
        parent::__construct($message);

        $this->nick = explode('!', $this->source)[0];
    }

    public function getEvents(): array
    {
        return [
            new Event(
                Event::JOIN,
                [
                    'nick' => $this->nick
                ]
            ),
        ];
    }
}
