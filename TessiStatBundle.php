<?php

namespace Da\StatBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Da\StatBundle\DependencyInjection\Compiler\StatHandlerCompilerPass;

class DaStatBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new StatHandlerCompilerPass());
    }
}
