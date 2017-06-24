<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Phergie;

use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Event\Event;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use WyriHaximus\React\PSR3\Phergie\Plugin;

final class PluginTest extends TestCase
{
    public function testGetLogger()
    {
        $logger = (new Plugin('channel'))->getLogger();
        self::assertInstanceOf(LoggerInterface::class, $logger);
    }

    public function testGetSubscribedEvents()
    {
        self::assertSame([
            'irc.sent.user' => 'setQueue',
        ], (new Plugin('channel'))->getSubscribedEvents());
    }

    public function testLog()
    {
        $plugin = new Plugin('channel');
        $logger = $plugin->getLogger();
        $event = $this->prophesize(Event::class)->reveal();
        $queue = $this->prophesize(Queue::class);
        $queue->ircPrivmsg('channel', 'info message')->shouldBeCalled();

        $plugin->setQueue($event, $queue->reveal());

        $logger->info('message');
    }
}
