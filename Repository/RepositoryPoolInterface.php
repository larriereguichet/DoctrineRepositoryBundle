<?php

namespace LAG\DoctrineRepositoryBundle\Repository;

/**
 * RepositoryPool interface
 */
interface RepositoryPoolInterface
{
    /**
     * Add an doctrine repository to the pool
     *
     * @param DoctrineRepository $repository
     */
    public function add(DoctrineRepository $repository);

    /**
     * Return a doctrine repository according to its class name
     *
     * @param $className
     * @return DoctrineRepository
     */
    public function get($className);

    /**
     * Return true if the repository with class name $className is in the pool
     *
     * @param $className
     * @return mixed
     */
    public function has($className);
}
