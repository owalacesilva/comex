<?php

namespace Application\Commands;

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

final class MinimalCommand extends CLI
{
    protected function setup(Options $options)
    {
        $options->setHelp('A very minimal example that does nothing but print a version');
        $options->registerOption('version', 'print version', 'v');
    }

    protected function main(Options $options)
    {
        if ($options->getOpt('version')) {
            $this->info('1.0.0');
        } else {
            echo $options->help();
        }
    }
}