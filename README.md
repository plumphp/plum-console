<h1 align="center">
    <img src="http://cdn.florian.ec/plum-logo.svg" alt="Plum" width="300">
</h1>

> PlumConsole integrates the [Symfony Console](http://symfony.com/doc/current/components/console/introduction.html)
component into Plum. [Plum](https://github.com/plumphp/plum) is a data processing pipeline for PHP.

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

Please refer to the [Plum documentation](https://github.com/plumphp/plum/blob/master/docs/index.md) for more
information about Plum in general.

PlumConsole currently contains two writers: [`ConsoleProgressWriter`](#consoleprogresswriter) and 
[`ConsoleTableWriter`](#consoletablewriter). Both are intended to be used in an application that use the
[Symfony Console](http://symfony.com/doc/current/components/console/introduction.html) component. In addition it
provides [`ExceptionFormatter`](#exceptionformatter), which helps you printing nice error messages to users.

### `ConsoleProgressWriter`

`Plum\PlumConsole\ConsoleProgressWriter` displays the progress of a workflow in the console.

```php
use Plum\PlumConsole\ConsoleProgressWriter;
use Symfony\Component\Console\Helper\ProgressBar;

// ...
// $output is an instance of Symfony\Component\Console\Output\OutputInterface
// $reader is an instance of Plum\Plum\Reader\ReaderInterface

$writer = new ConsoleProgressWriter(new ProgressBar($output, $reader->count()));
```

### `ConsoleTableWriter`

`Plum\PlumConsole\ConsoleTableWriter` outputs the processed data as table in the console.

```php
use Plum\PlumConsole\ConsoleTableWriter;
use Symfony\Component\Console\Helper\Table;

// ...
// $output is an instance of Symfony\Component\Console\Output\OutputInterface

$writer = new ConsoleTableWriter(new Table($output));

// ConsoleTableWriter can automatically detect and set the headers
$writer->autoDetectHeader();
```


### `ExceptionFormatter`

Plum does offer the option to catch exceptions. When this option is active the workflow can resume processing even if
an item is causing errors. However, you have to manually output exceptions, which can be a tedious process.
`Plum\PlumConsole\ExceptionFormatter` can help you printing exceptions.

The granularity of the information can be controlled using the `--verbose` flag of Symfony Console. By default, the
exception messages will be printed when the application is invoked using `--verbose` or `-v` and the messages and
stack traces are printed when using `-vv`.

```php
use Plum\Plum\Workflow;
use Plum\PlumConsole\ExceptionFormatter;

$workflow = Workflow(['resumeOnError' => true]);
// Build workflow
$result = $workflow->process($reader);

// $output is an instance of Symfony\Component\Console\Output\OutputInterface

$formatter = new ExceptionFormatter($output);
$formatter->outputExceptions($result);
```

The formatter offers options to configure both the granularity when messages and stack traces are shown and let you
configure how they are printed. The following example shows all available options and the default values. Please note,
that `messageTemplate` and `traceTemplate` are being printed using `sprintf()`.

```php
use Plum\PlumConsole\ExceptionFormatter;
use Symfony\Component\Console\Output\OutputInterface;

// $output is an instance of Symfony\Component\Console\Output\OutputInterface 

$formatter = new ExceptionFormatter($output, [
    'minMessageVerbosity' => OutputInterface::VERBOSITY_VERBOSE,
    'minTraceVerbosity'   => OutputInterface::VERBOSITY_VERY_VERBOSE,
    'messageTemplate'     => '<error>%s</error>',
    'traceTemplate'       => '%s',
]);
```


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
