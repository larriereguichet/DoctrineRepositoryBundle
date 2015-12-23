<?php

namespace LAG\DoctrineRepositoryBundle\Tests\DoctrineRepositoryBundle\DependencyInjection;

use LAG\DoctrineRepositoryBundle\DependencyInjection\RepositoryCompilerPass;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Test repository compiler pass
 */
class RepositoryCompilerPassTest extends PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        // TEST 1
        // must work with no tagged services
        $containerBuilder = new ContainerBuilder();
        $compilerPass = new RepositoryCompilerPass();
        $compilerPass->process($containerBuilder);

        // TEST 2
        // must add repository tagged service into the repository pool
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setDefinition('lag.repository.repository_pool', new Definition());

        $repository = new Definition();
        $repository->addTag('doctrine.repository');
        $containerBuilder->setDefinition('repository1', $repository);
        $repository = new Definition();
        $repository->addTag('doctrine.repository');
        $containerBuilder->setDefinition('repository2', $repository);

        $compilerPass = new RepositoryCompilerPass();
        $compilerPass->process($containerBuilder);
        $methodCalls = $containerBuilder
            ->getDefinition('lag.repository.repository_pool')
            ->getMethodCalls();

        $this->assertCount(2, $methodCalls);

        foreach ($methodCalls as $call) {
            /** @var Reference $reference */
            $reference = $call[1][0];
            // test reference assignment
            $this->assertEquals('add', $call[0]);
            $this->assertInstanceOf('Symfony\Component\DependencyInjection\Reference', $reference);
            $this->assertTrue(in_array($reference->__toString(), [
                'repository1', 'repository2'
            ]));
        }
    }
}
