<?php

namespace Plum\PlumConsole;

use Plum\Plum\Writer\WriterInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * ConsoleTableWriter
 *
 * @package   Plum\PlumConsole
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class ConsoleTableWriter implements WriterInterface
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * @var string[]|null
     */
    protected $header;

    /**
     * @var bool
     */
    protected $autoDetectHeader = false;

    /**
     * @param Table $table
     *
     * @codeCoverageIgnore
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @param bool $autoDetectHeader
     *
     * @return ConsoleTableWriter
     */
    public function autoDetectHeader($autoDetectHeader = true)
    {
        $this->autoDetectHeader = $autoDetectHeader;

        return $this;
    }

    /**
     * Write the given item.
     *
     * @param mixed $item
     *
     * @return void
     */
    public function writeItem($item)
    {
        if ($this->autoDetectHeader && !$this->header) {
            $this->header = array_keys($item);
            $this->table->setHeaders($this->header);
        }

        $this->table->addRow($item);
    }

    /**
     * Prepare the writer.
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    public function prepare()
    {
    }

    /**
     * Finish the writer.
     *
     * @return void
     */
    public function finish()
    {
        $this->table->render();
    }
}
