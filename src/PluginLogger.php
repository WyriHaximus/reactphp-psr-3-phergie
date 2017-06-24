<?php declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Phergie;

use Psr\Log\AbstractLogger;
use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\processPlaceHolders;

final class PluginLogger extends AbstractLogger
{
    /**
     * @var LogStream
     */
    private $stream;

    /**
     * PluginLogger constructor.
     * @param LogStream $stream
     */
    public function __construct(LogStream $stream)
    {
        $this->stream = $stream;
    }

    public function log($level, $message, array $context = [])
    {
        checkCorrectLogLevel($level);
        $message = (string)$message;
        $message = processPlaceHolders($message, $context);
        $this->stream->onNext(new Entry($level, $message, $context));
    }
}
