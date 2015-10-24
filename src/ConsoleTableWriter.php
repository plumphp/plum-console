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

use Cocur\Vale\Vale;
use InvalidArgumentException;
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
     * @param string[] $header
     *
     * @return ConsoleTableWriter
     */
    public function setHeader(array $header)
    {
        $this->header = $header;

        return $this;
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
            $this->handleAutoDetectHeader($item);
        }

        $this->table->addRow(
            $this->getValues($item, $this->getKeys($item))
        );
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
        if ($this->header !== null) {
            $this->table->setHeaders($this->header);
        }
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

    /**
     * @param mixed $item
     */
    protected function handleAutoDetectHeader($item)
    {
        if (!is_array($item)) {
            throw new InvalidArgumentException('Plum\PlumConsole\ConsoleTableWriter can only auto detect headers for '.
                                               'array items. For items of a type other than array the headers have '.
                                               'to be set manually.');
        }

        $this->header = array_keys($item);
        $this->table->setHeaders($this->header);
    }

    /**
     * @param mixed $item
     *
     * @return string[]
     */
    protected function getKeys($item)
    {
        if (is_array($item)) {
            return array_keys($item);
        } else if ($this->header && is_object($item)) {
            return $this->header;
        }

        throw new InvalidArgumentException(sprintf(
            'Plum\PlumConsole\ConsoleTableWriter currently only supports array items or objects if headers '.
            'are set using the setHeader() method. You have passed an item of type "%s" to writeItem().',
            gettype($item)
        ));
    }

    /**
     * @param mixed    $item
     * @param string[] $keys
     *
     * @return array
     */
    protected function getValues($item, array $keys)
    {
        $values = [];
        foreach ($keys as $key) {
            $values[] = Vale::get($item, $key);
        }

        return $values;
    }
}
