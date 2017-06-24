<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Phergie;

use Psr\Log\Test\LoggerInterfaceTest;
use WyriHaximus\React\PSR3\Phergie\Entry;
use WyriHaximus\React\PSR3\Phergie\LogStream;
use WyriHaximus\React\PSR3\Phergie\PluginLogger;

final class PluginLoggerTest extends LoggerInterfaceTest
{
    /**
     * @var array
     */
    private $logs = [];

    public function getLogger()
    {
        $stream = new LogStream();
        $stream->subscribe(function (Entry $entry) {
            $this->logs[] = $entry->getPsrMessage();
        });

        return new PluginLogger($stream);
    }

    public function getLogs()
    {
        return $this->logs;
    }
}
