<?php

namespace LAG\DoctrineRepositoryBundle;

use LAG\DoctrineRepositoryBundle\DependencyInjection\RepositoryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LAGDoctrineRepositoryBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // register repository compiler pass
        $container->addCompilerPass(new RepositoryCompilerPass());
    }
}
