<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Console;

use DevHelper\Utils\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractCommand extends SymfonyCommand
{
    protected string $name;

    protected InputInterface $input;

    protected SymfonyStyle $output;

    protected int $verbosity = OutputInterface::VERBOSITY_NORMAL;

    protected ?string $signature;

    protected array $verbosityMap = [];

    protected HelperSet $helperSet;

    public function __construct(string $name = null)
    {
        $this->helperSet = new HelperSet([
            new QuestionHelper(),
        ]);

        if (! $name && $this->name) {
            $name = $this->name;
        }

        if (isset($this->signature)) {
            $this->configureUsingFluentDefinition();
        } else {
            parent::__construct($name);
        }
    }

    /**
     * Run the console command.
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $this->output = new SymfonyStyle($input, $output);

        return parent::run($this->input = $input, $this->output);
    }

    /**
     * Confirm a question with the user.
     */
    public function confirm(string $question, bool $default = false): bool
    {
        return $this->output->confirm($question, $default);
    }

    /**
     * Prompt the user for input.
     *
     * @param null|mixed $default
     */
    public function ask(string $question, $default = null)
    {
        return $this->output->ask($question, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function askAndValidate($question, $validator = null, $attempts = null, $default = null)
    {
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
        $helper = $this->helperSet->get('question');
        $question = new Question($question, $default);
        $question->setValidator($validator);
        $question->setMaxAttempts($attempts);

        return $helper->ask($this->input, $this->getErrorOutput(), $question);
    }

    /**
     * Prompt the user for input with auto completion.
     */
    public function anticipate(string $question, array $choices, $default = null)
    {
        return $this->askWithCompletion($question, $choices, $default);
    }

    /**
     * Prompt the user for input with auto completion.
     */
    public function askWithCompletion(string $question, array $choices, $default = null)
    {
        $question = new Question($question, $default);

        $question->setAutocompleterValues($choices);

        return $this->output->askQuestion($question);
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     */
    public function secret(string $question, bool $fallback = true)
    {
        $question = new Question($question);

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }

    /**
     * Give the user a multiple choice from an array of answers.
     */
    public function choiceMultiple(
        string $question,
        array $choices,
        $default = null,
        ?int $attempts = null
    ): array {
        $question = new ChoiceQuestion($question, $choices, $default);

        $question->setMaxAttempts($attempts)->setMultiselect(true);

        return $this->output->askQuestion($question);
    }

    /**
     * Give the user a single choice from an array of answers.
     */
    public function choice(
        string $question,
        array $choices,
        $default = null,
        ?int $attempts = null
    ): string {
        return $this->choiceMultiple($question, $choices, $default, $attempts)[0];
    }

    /**
     * Format input to textual table.
     */
    public function table(array $headers, array $rows, $tableStyle = 'default', array $columnStyles = []): void
    {
        $table = new Table($this->output);

        $table->setHeaders((array) $headers)->setRows($rows)->setStyle($tableStyle);

        foreach ($columnStyles as $columnIndex => $columnStyle) {
            $table->setColumnStyle($columnIndex, $columnStyle);
        }

        $table->render();
    }

    /**
     * Write a string as standard output.
     *
     * @param mixed $string
     * @param null|mixed $style
     * @param null|mixed $verbosity
     */
    public function line($string, $style = null, $verbosity = null)
    {
        $styled = $style ? "<{$style}>{$string}</{$style}>" : $string;
        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }

    /**
     * Write a string as information output.
     *
     * @param mixed $string
     * @param null|mixed $verbosity
     */
    public function info($string, $verbosity = null)
    {
        $this->line($string, 'info', $verbosity);
    }

    /**
     * Write a string as comment output.
     *
     * @param mixed $string
     * @param null|mixed $verbosity
     */
    public function comment($string, $verbosity = null)
    {
        $this->line($string, 'comment', $verbosity);
    }

    /**
     * Write a string as question output.
     *
     * @param mixed $string
     * @param null|mixed $verbosity
     */
    public function question($string, $verbosity = null)
    {
        $this->line($string, 'question', $verbosity);
    }

    /**
     * Write a string as error output.
     *
     * @param mixed $string
     * @param null|mixed $verbosity
     */
    public function error($string, $verbosity = null)
    {
        $this->line($string, 'error', $verbosity);
    }

    /**
     * Write a string as warning output.
     *
     * @param mixed $string
     * @param null|mixed $verbosity
     */
    public function warn($string, $verbosity = null)
    {
        if (! $this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');
            $this->output->getFormatter()->setStyle('warning', $style);
        }
        $this->line($string, 'warning', $verbosity);
    }

    /**
     * Write a string in an alert box.
     *
     * @param mixed $string
     */
    public function alert($string)
    {
        $length = Str::length(strip_tags($string)) + 12;
        $this->comment(str_repeat('*', $length));
        $this->comment('*     ' . $string . '     *');
        $this->comment(str_repeat('*', $length));
        $this->output->newLine();
    }

    /**
     * Handle the current command.
     */
    abstract public function handle();

    /**
     * Set the verbosity level.
     *
     * @param mixed $level
     */
    protected function setVerbosity($level)
    {
        $this->verbosity = $this->parseVerbosity($level);
    }

    /**
     * Get the verbosity level in terms of Symfony's OutputInterface level.
     *
     * @param null|mixed $level
     */
    protected function parseVerbosity($level = null): int
    {
        if (isset($this->verbosityMap[$level])) {
            $level = $this->verbosityMap[$level];
        } elseif (! is_int($level)) {
            $level = $this->verbosity;
        }
        return $level;
    }

    /**
     * Specify the arguments and options on the command.
     */
    protected function specifyParameters(): void
    {
        // We will loop through all of the arguments and options for the command and
        // set them all on the base command instance. This specifies what can get
        // passed into these commands as "parameters" to control the execution.
        if (method_exists($this, 'getArguments')) {
            foreach ($this->getArguments() ?? [] as $arguments) {
                call_user_func_array([$this, 'addArgument'], $arguments);
            }
        }

        if (method_exists($this, 'getOptions')) {
            foreach ($this->getOptions() ?? [] as $options) {
                call_user_func_array([$this, 'addOption'], $options);
            }
        }
    }

    /**
     * Configure the console command using a fluent definition.
     */
    protected function configureUsingFluentDefinition()
    {
        [$name, $arguments, $options] = Parser::parse($this->signature);

        parent::__construct($this->name = $name);

        // After parsing the signature we will spin through the arguments and options
        // and set them on this command. These will already be changed into proper
        // instances of these "InputArgument" and "InputOption" Symfony classes.
        $this->getDefinition()->addArguments($arguments);
        $this->getDefinition()->addOptions($options);
    }

    protected function configure()
    {
        parent::configure();
        if (! isset($this->signature)) {
            $this->specifyParameters();
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $callback = function () {
            try {
                call([$this, 'handle']);
            } catch (\Throwable $exception) {
                throw $exception;
            }
            return 0;
        };

        return $callback();
    }

    private function getErrorOutput(): OutputInterface
    {
        if ($this->output instanceof ConsoleOutputInterface) {
            return $this->output->getErrorOutput();
        }

        return $this->output;
    }
}
