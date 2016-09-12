<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Resource;

class ResourceFactory implements ResourceFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getInstance(string $path): Resource
    {
        return new Resource($path);
    }
}
