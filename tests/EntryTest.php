<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Phergie;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use WyriHaximus\React\PSR3\Phergie\Entry;

final class EntryTest extends TestCase
{
    public function testGetters()
    {
        $entry = new Entry(LogLevel::DEBUG, 'message', ['context']);
        self::assertSame($entry->getLevel(), LogLevel::DEBUG);
        self::assertSame($entry->getMessage(), 'message');
        self::assertSame($entry->getContext(), ['context']);
        self::assertSame($entry->getPsrMessage(), LogLevel::DEBUG . ' message');
    }
}
