<?php

namespace MPScholten\RequestParser\Foundation\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateParser extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('parser')
            ->setDescription('Generates an empty custom parser class')
            ->addArgument('name', InputArgument::REQUIRED, 'The parser name, e.g. `IpAddressParser`');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if (!$this->endsWith($name, 'Parser')) {
            $output->writeln('<error>The class name has to end with `Praser`, e.g. `IpAddressParser`</error>');
            return 1;
        }
        if (!$this->startsWithUpperCase($name)) {
            $output->writeln('<error>The class name has to start with an upper case latter</error>');
            return 1;
        }

        $path = $this->getPathTo("src/$name.php");
        $content = $this->generateContent($name);

        file_put_contents($path, $content);

        $output->writeln("<info> + $path</info>");
    }

    private function generateContent($name)
    {
        return <<<CODE
<?php

namespace MPScholten\RequestParser;

class $name extends AbstractValueParser
{
    protected function describe()
    {
        // TODO: describe the expected input, e.g. "a valid IP address"
        return "a ...";
    }

    protected function parse(\$value)
    {
        // TODO: handle type casting, validation, etc.
        return (string) \$value;
    }

    public function defaultsTo(\$defaultValue)
    {
        return parent::defaultsTo(\$defaultValue);
    }

    public function required(\$invalidValueMessage = null, \$notFoundMessage = null)
    {
        return parent::required(\$invalidValueMessage, \$notFoundMessage);
    }
}

CODE;

    }
}