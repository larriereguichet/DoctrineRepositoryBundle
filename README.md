[![Build Status](https://travis-ci.org/larriereguichet/DoctrineRepositoryBundle.svg?branch=master)](https://travis-ci.org/larriereguichet/DoctrineRepositoryBundle.svg?branch=master)

# DoctrineRepositoryBundle

Implementation of Repository pattern for Doctrine ORM

## Introduction

This bundle allows developpers to retrieve a Doctrine repository without passing by the EntityManager. Thoses repositories are exposed as service and constructed without using the Doctrine repository factory.

## Example

- Define your repository class in your Doctrine entity as usual

```php
/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="MyVendor\MyBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article {
...
```

- Define the service with the tag "doctrine_repository"

```yml
    my_repository:
        class: MyVendor\MyBundle\Repository\ArticleRepository
        tags:
            - {name: doctrine.repository}
```

- Retrieve your repository from service container :
```php
...
$this->get('my_repository');
...
```
