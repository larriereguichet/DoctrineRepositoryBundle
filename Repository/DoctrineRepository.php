<?php

namespace LAG\DoctrineRepositoryBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract doctrine repository
 */
abstract class DoctrineRepository implements RepositoryInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entityClassName;

    /**
     * Find an entity by its identifier.
     *
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this
            ->repository
            ->find($id);
    }

    /**
     * Find all entities in the repository.
     *
     * @return array|Collection
     */
    public function findAll()
    {
        return $this
            ->repository
            ->findAll();
    }

    /**
     * Find all entities matching criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array|Collection
     */
    public function findBy(array $criteria, array $orderBy = [], $limit = null, $offset = null)
    {
        return $this
            ->repository
            ->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Find one entity matching criteria.
     *
     * @param array $criteria
     * @return mixed
     */
    public function findOneBy(array $criteria)
    {
        return $this
            ->repository
            ->findOneBy($criteria);
    }

    /**
     * Save an entity.
     *
     * @param $entity
     */
    public function save($entity)
    {
        $this->objectManager->persist($entity);
        $this->objectManager->flush();
    }

    /**
     * Delete an entity.
     *
     * @param $entity
     */
    public function delete($entity)
    {
        $this->objectManager->remove($entity);
        $this->objectManager->flush();
    }

    /**
     * Create a doctrine QueryBuilder
     *
     * @param $alias
     * @param null $indexBy
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this
            ->repository
            ->createQueryBuilder($alias, $indexBy);
    }

    /**
     * Return repository class name
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->entityClassName;
    }

    /**
     * @param EntityRepository $repository
     * @return DoctrineRepository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $entityClassName
     * @return DoctrineRepository
     */
    public function setEntityClassName($entityClassName)
    {
        $this->entityClassName = $entityClassName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityClassName()
    {
        return $this->entityClassName;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     * @return $this
     */
    public function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;

        return $this;
    }
}
