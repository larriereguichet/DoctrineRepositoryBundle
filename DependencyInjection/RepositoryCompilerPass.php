<?php

namespace LAG\DoctrineRepositoryBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Add repository tagged service definition to the repository pool
 */
class RepositoryCompilerPass implements CompilerPassInterface
{
    /**
     * Load tagged repositories and add it to the repository pool
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lag.repository.repository_pool')) {
            return;
        }
        // find service with doctrine.repository tag
        $repositoryTags = $container->findTaggedServiceIds('doctrine.repository');
        // get pool definition
        $poolDefinition = $container->findDefinition('lag.repository.repository_pool');

        foreach ($repositoryTags as $serviceId => $tags) {
            // add repository to the pool
            $poolDefinition->addMethodCall('add', [
                new Reference($serviceId),
            ]);
        }
    }
}
