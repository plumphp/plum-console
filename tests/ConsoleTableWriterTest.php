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

use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * ConsoleTableWriterTest
 *
 * @package   Plum\PlumConsole
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class ConsoleTableWriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Console\Helper\Table|\Mockery\MockInterface
     */
    protected $table;

    /**
     * @var ConsoleTableWriter
     */
    protected $writer;

    public function setUp()
    {
        $this->table  = Mockery::mock('Symfony\Component\Console\Helper\Table');
        $this->writer = new ConsoleTableWriter($this->table);
    }

    /**
     * @test
     * @covers Plum\PlumConsole\ConsoleTableWriter::writeItem()
     */
    public function writeItemAddsItemToTable()
    {
        $this->table->shouldReceive('addRow')->with(['foo', 'bar'])->once();

        $this->writer->writeItem(['foo', 'bar']);
    }

    /**
     * @test
     * @covers Plum\PlumConsole\ConsoleTableWriter::setHeader()
     * @covers Plum\PlumConsole\ConsoleTableWriter::prepare()
     */
    public function setHeaderShouldManuallySetHeaders()
    {
        $this->table->shouldReceive('setHeaders')->with(['a', 'b'])->once();
        $this->table->shouldReceive('addRow')->with(['foo', 'bar'])->once();

        $this->writer->setHeader(['a', 'b']);
        $this->writer->prepare();
        $this->writer->writeItem(['foo', 'bar']);
    }

    /**
     * @test
     * @covers Plum\PlumConsole\ConsoleTableWriter::autoDetectHeader()
     * @covers Plum\PlumConsole\ConsoleTableWriter::writeItem()
     */
    public function writeItemDetectsHeaderWithAutoDetectHeaderOption()
    {
        $this->table->shouldReceive('setHeaders')->with(['a', 'b'])->once();
        $this->table->shouldReceive('addRow')->with(['a' => 'foo', 'b' => 'bar'])->once();

        $this->writer->autoDetectHeader();
        $this->writer->writeItem(['a' => 'foo', 'b' => 'bar']);
    }

    /**
     * @test
     * @covers Plum\PlumConsole\ConsoleTableWriter::finish()
     */
    public function finishRendersTable()
    {
        $this->table->shouldReceive('render')->once();
        $this->writer->finish();
    }
}
