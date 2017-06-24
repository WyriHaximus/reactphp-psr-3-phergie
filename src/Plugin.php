<?php declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Phergie;

use Phergie\Irc\Bot\React\AbstractPlugin;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Event\Event;
use Psr\Log\LoggerInterface;

final class Plugin extends AbstractPlugin
{
    /**
     * @var string
     */
    private $channel;

    /**
     * @var LogStream
     */
    private $stream;

    /**
     * @var PluginLogger
     */
    private $pluginLogger;

    public function __construct(string $channel)
    {
        $this->channel = $channel;
        $this->stream = new LogStream();
        $this->pluginLogger = new PluginLogger($this->stream);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->pluginLogger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'irc.sent.user' => 'setQueue',
        ];
    }

    public function setQueue(Event $event, Queue $queue)
    {
        $this->stream->subscribe(function (Entry $entry) use ($queue) {
            $queue->ircPrivmsg($this->channel, $entry->getPsrMessage());
        });
    }
}
