<?php

/**
 * This file is part of plumphp/plum-console.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\PlumConsole;

use Exception;
use Mockery;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ExceptionFormatterTest.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class ExceptionFormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface|\Mockery\MockInterface
     */
    private $output;

    public function setUp()
    {
        $this->output = Mockery::mock('\Symfony\Component\Console\Output\OutputInterface');
    }

    /**
     * @test
     * @covers Plum\PlumConsole\ExceptionFormatter::outputExceptions()
     * @covers Plum\PlumConsole\ExceptionFormatter::outputExceptionMessage()
     */
    public function listExceptionsShouldOutputMessagesIfVerbose()
    {
        /** @var \Plum\Plum\Result|\Mockery\MockInterface $result */
        $result = Mockery::mock('\Plum\Plum\Result');
        $result->shouldReceive('getExceptions')->once()->andReturn([
            $this->getMockException('Exception #1'),
            $this->getMockException('Exception #2'),
        ]);

        $this->output->shouldReceive('writeln')->with('<error>Exception #1</error>')->once();
        $this->output->shouldReceive('writeln')->with('<error>Exception #2</error>')->once();
        $this->output->shouldReceive('getVerbosity')->andReturn(OutputInterface::VERBOSITY_VERBOSE);

        $formatter = new ExceptionFormatter($this->output);
        $formatter->outputExceptions($result);
    }

    /**
     * @test
     * @covers Plum\PlumConsole\ExceptionFormatter::outputExceptions()
     * @covers Plum\PlumConsole\ExceptionFormatter::outputExceptionTrace()
     */
    public function listExceptionsShouldOutputStackTraceIfVeryVerbose()
    {
        /** @var \Plum\Plum\Result|\Mockery\MockInterface $result */
        $result = Mockery::mock('\Plum\Plum\Result');
        $result->shouldReceive('getExceptions')->once()->andReturn([
            $this->getMockException('Exception #1', 'Trace #1'),
        ]);

        $this->output->shouldReceive('writeln')->with('<error>Exception #1</error>')->once();
        $this->output->shouldReceive('writeln')->with('Trace #1')->once();
        $this->output->shouldReceive('getVerbosity')->andReturn(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $formatter = new ExceptionFormatter($this->output);
        $formatter->outputExceptions($result);
    }

    /**
     * @param string      $message
     * @param string|null $traceAsString
     *
     * @return Exception
     */
    protected function getMockException($message, $traceAsString = null)
    {
        $exception = Mockery::mock('\Throwable');
        $exception->shouldReceive('getMessage')->andReturn($message);
        if ($traceAsString) {
            $exception->shouldReceive('getTraceAsString')->andReturn($traceAsString);
        }

        return $exception;
    }
}
