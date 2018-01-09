# PSR-3 Logger Plugin for Phergie

[![Build Status](https://travis-ci.org/WyriHaximus/reactphp-psr-3-phergie.png)](https://travis-ci.org/WyriHaximus/reactphp-psr-3-phergie)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/react-psr-3-phergie/v/stable.png)](https://packagist.org/packages/WyriHaximus/react-psr-3-phergie)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/react-psr-3-phergie/downloads.png)](https://packagist.org/packages/WyriHaximus/react-psr-3-phergie)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-psr-3-phergie/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-psr-3-phergie/?branch=master)
[![License](https://poser.pugx.org/wyrihaximus/react-psr-3-phergie/license.png)](https://packagist.org/packages/wyrihaximus/react-psr-3-phergie)

## Installation ##

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `~`.

```
composer require wyrihaximus/react-psr-3-phergie 
```

## Usage ##

Make sure you order everything the same way as in the example, this 
matters for keeping your IRC password out of your logs: 

```php
// Zero create the ReactPHP Event loop (assuming you don't already did)
$loop = Factory::create();

// First create the logger, in this example Monolog is assumed
$logger = new Logger('your app');

// Then create the plugin
$plugin = new PhergiePSR3Plugin('#logs-channel');

// Thirdly set up your logger the way you like
/**
 * Logger set up magic
 */
 
// Fourth add handlers
/**
 * Add any other handlers here, before the fith step, to ensure it 
 * doesn't leak the password 
 */

// Fith wrap the logger in wyrihaximus/psr-3-keyword-filter
$logger = new MessageKeywordFilterLogger(['PASS', 'PRIVMSG'], $logger);

// Sixth create the Phergie Client
$client = new Client();
$client->setLoop($loop);
$client->setLogger($logger); 

// Seventh create the Phergie bot
$bot = new Bot();

// Eighth create the Pergie connection
$connection = new Connection([
    // Your connection config here
]);

// Nineth add the config combining the connection and plugin
$bot->setConfig([
    'plugins' => [
        $loggingPlugin,
        new EventFilterPlugin([ // phergie/phergie-irc-plugin-react-eventfilter
            'filter' => new ConnectionFilter([
                $connection,
            ]),
            'plugins' => [
                new AutoJoinPlugin([ // phergie/phergie-irc-plugin-react-autojoin
                    'channels' => [
                        '#logs-channel',
                    ],
                ]),
            ],
        ]),
    ],
    'connections' => [
        $connection,
    ],
]);

// Tenth set the client and run the bot (note that the false is to ensure this doesn't run the event loop)
$bot->setClient($client);
$bot->run(false);
```

## License ##

Copyright 2018 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
