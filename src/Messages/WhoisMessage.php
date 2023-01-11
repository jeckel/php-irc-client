<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 11/01/2023
 */

declare(strict_types=1);

namespace Jerodev\PhpIrcClient\Messages;

use Jerodev\PhpIrcClient\Helpers\Event;

class WhoisMessage extends IrcMessage
{
    protected $realName = '';
    /** @var string */
    protected $nick = '';
    /** @var string */
    protected $user = '';
    /** @var string */
    protected $host = '';

    public function __construct(string $message)
    {
        parent::__construct($message);

        $suffix = explode(' ', $this->commandSuffix() ?? '   ');
        $this->nick = $suffix[1];
        $this->user = $suffix[2];
        $this->host = $suffix[3];

        $this->realName = $this->payload;
    }

    public function getEvents(): array
    {
        return [
            new Event(
                Event::WHOIS,
                [
                    'nick' => $this->nick,
                    'user' => $this->user,
                    'host' => $this->host,
                    'realName' => $this->realName
                ]
            ),
        ];
    }

    public function realName(): string
    {
        return $this->realName;
    }

    public function nick()
    {
        return $this->nick;
    }

    public function user()
    {
        return $this->user;
    }

    public function host()
    {
        return $this->host;
    }
}
