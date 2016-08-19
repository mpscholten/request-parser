<?php

namespace MPScholten\RequestParser\Foundation\Command;

use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    private function getApplicationPath()
    {
        $path = getcwd();
        if (!$this->isValidApplicationPath($path)) {
            throw new \RuntimeException("This command has to be called from the root request-parser directory, but was invoked from $path");
        }

        return $path;
    }

    protected function getPathTo($directory)
    {
        return $this->getApplicationPath() . "/$directory";
    }

    private function isValidApplicationPath($path)
    {
        return $this->endsWith($path, 'request-parser');
    }

    protected function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }

    protected function startsWithUpperCase($str) {
        $chr = mb_substr ($str, 0, 1, "UTF-8");
        return mb_strtolower($chr, "UTF-8") != $chr;
    }
}
