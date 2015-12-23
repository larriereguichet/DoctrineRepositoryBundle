<?php

namespace LAG\DoctrineRepositoryBundle\Event\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Exception;
use LAG\DoctrineRepositoryBundle\Repository\RepositoryPool;

class MetadataEventSubscriber implements EventSubscriber
{
    /**
     * @var RepositoryPool
     */
    protected $repositoryPool;

    /**
     * @var array
     */
    protected $classeLoaded = [];

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata
        ];
    }

    /**
     * Load repository data according to doctrine mapping information
     *
     * @param LoadClassMetadataEventArgs $args
     * @throws Exception
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $args->getClassMetadata();
        // entity class name
        $className = $metadata->getName();

        // we load repository once per class
        if (in_array($className, $this->classeLoaded)) {
            return;
        }
        $this->classeLoaded[] = $className;

        // a custom repository class must be set and it must be in the repository pool
        if ($metadata->customRepositoryClassName and $this
                ->repositoryPool
                ->has($metadata->customRepositoryClassName)
        ) {
            // load repository from pool (hydrated by the repository compiler pass)
            $repository = $this
                ->repositoryPool
                ->get($metadata->customRepositoryClassName);

            // create entity doctrine repository
            $entityManager = $args->getEntityManager();
            $doctrineRepository = new EntityRepository($entityManager, $entityManager->getClassMetadata($className));

            // hydrate repository with doctrine data
            $repository
                ->setEntityClassName($className)
                ->setObjectManager($entityManager)
                ->setRepository($doctrineRepository)
            ;
        }
    }

    /**
     * @return RepositoryPool
     */
    public function getRepositoryPool()
    {
        return $this->repositoryPool;
    }

    /**
     * @param RepositoryPool $repositoryPool
     */
    public function setRepositoryPool($repositoryPool)
    {
        $this->repositoryPool = $repositoryPool;
    }
}
