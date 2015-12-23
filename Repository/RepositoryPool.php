<?php

namespace LAG\DoctrineRepositoryBundle\Repository;

use Exception;

class RepositoryPool implements RepositoryPoolInterface
{
    /**
     * @var DoctrineRepository[]
     */
    protected $pool = [];

    /**
     * Add an doctrine repository to the pool
     *
     * @param DoctrineRepository $repository
     */
    public function add(DoctrineRepository $repository)
    {
        $this->pool[get_class($repository)] = $repository;
    }

    /**
     * Return a doctrine repository according to its class name
     *
     * @param $className
     * @return DoctrineRepository
     * @throws Exception
     */
    public function get($className)
    {
        if (!$this->has($className)) {
            throw new Exception('Repository ' . $className . ' not found');
        }
        return $this->pool[$className];
    }

    /**
     * Return true if the repository with class name $className is in the pool
     *
     * @param $className
     * @return mixed
     */
    public function has($className)
    {
        return array_key_exists($className, $this->pool);
    }
}
