<?php

namespace Jerodev\PhpIrcClient;

final class IrcCommand
{
    /**
     * @see https://www.alien.net.au/irc/irc2numerics.html
     * @see https://codes-sources.commentcamarche.net/forum/affich-1003983-whois-return
     */
    const RPL_WELCOME = '001';
    const RPL_AWAY = '301';
    const RPL_WHOISUSER = '311';
    const RPL_WHOISSERVER = '312';
    const RPL_WHOISOPERATOR = '313';
    const RPL_WHOISIDLE = '317';
    const RPL_ENDOFWHOIS = '318';
    const RPL_WHOISCHANNELS = '319';
    const RPL_TOPIC = '332';
    const RPL_NAMREPLY = '353';
    const RPL_MOTD = '372';
}
