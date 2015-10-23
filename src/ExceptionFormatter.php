<?php

namespace Plum\PlumConsole;

use Exception;
use Plum\Plum\Result;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * ExceptionFormatter
 *
 * @package   Plum\PlumConsole
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class ExceptionFormatter
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var array
     */
    private $options = [
        'minMessageVerbosity' => OutputInterface::VERBOSITY_VERBOSE,
        'minTraceVerbosity'   => OutputInterface::VERBOSITY_VERY_VERBOSE,
        'messageTemplate'     => '<error>%s</error>',
        'traceTemplate'       => '%s',
    ];

    /**
     * @param OutputInterface $output
     * @param array           $options
     *
     * @codeCoverageIgnore
     */
    public function __construct(OutputInterface $output, array $options = [])
    {
        $this->output  = $output;
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @param Result $result
     */
    public function outputExceptions(Result $result)
    {
        foreach ($result->getExceptions() as $exception) {
            $this->outputExceptionMessage($exception)
                 ->outputExceptionTrace($exception);
        }

        return $this;
    }

    /**
     * @param Throwable $exception
     */
    protected function outputExceptionMessage(Throwable $exception)
    {
        if ($this->output->getVerbosity() >= $this->options['minMessageVerbosity']) {
            $this->output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
        }

        return $this;
    }

    /**
     * @param Throwable $exception
     */
    protected function outputExceptionTrace(Throwable $exception)
    {
        if ($this->output->getVerbosity() >= $this->options['minTraceVerbosity']) {
            $this->output->writeln(sprintf($this->options['traceTemplate'], $exception->getTraceAsString()));
        }

        return $this;
    }
}
