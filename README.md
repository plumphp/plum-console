<img src="https://florian.ec/img/plum/logo.png" alt="Plum">
====

> PlumConsole integrates the Symfony Console component into Plum. Plum is a data processing pipeline for PHP.

[![Build Status](https://travis-ci.org/plumphp/plum-console.svg?branch=master)](https://travis-ci.org/plumphp/plum-console)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/plumphp/plum-console/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/plumphp/plum-console/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/plumphp/plum-console/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/plumphp/plum-console/?branch=master)

Developed by [Florian Eckerstorfer](https://florian.ec) in Vienna, Europe.


Installation
------------

You can install Plum using [Composer](http://getcomposer.org).

```shell
$ composer require plumphp/plum-console
```


Usage
-----

PlumConsole currently contains two writers: `ConsoleProgressWriter` and `ConsoleTableWriter`. Both are intended to be
used in an application that uses Symfony Console component.

### ConsoleProgressWriter

`ConsoleProgressWriter` displays the progress of a workflow in the console.

```php
use Plum\PlumConsole\ConsoleProgressWriter;
use Symfony\Component\Console\Helper\ProgressBar;

// ...
// $output is an instance of Symfony\Component\Console\Output\OutputInterface
// $reader is an instance of Plum\Plum\Reader\ReaderInterface

$writer = new ConsoleProgressWriter(new ProgressBar($output, $reader->count()));
```

### ConsoleTableWriter

`ConsoleTableWriter` outputs the processed data as table in the console.

```php
use Plum\PlumConsole\ConsoleTableWriter;

// ...
// $output is an instance of Symfony\Component\Console\Output\OutputInterface

$writer = new ConsoleTableWriter(new Table($output));

// ConsoleTableWriter can automatically detect and set the headers
$writer->autoDetectHeader();
```

Please refer to the [Plum documentation](https://github.com/plumphp/plum/blob/master/docs/index.md) for more
information about Plum.


Change Log
----------

### Version 0.3 (15 May 2015)

- Add `ConsoleTableWriter`

### Version 0.2.1 (28 April 2015)

- Fix Plum version

### Version 0.2 (21 April 2015)

- Fix dependency to Plum

### Version 0.1 (24 March 2014)

- Initial release
- Works with Plum v0.1


License
-------

The MIT license applies to plumphp/plum-console. For the full copyright and license information,
please view the LICENSE file distributed with this source code.
