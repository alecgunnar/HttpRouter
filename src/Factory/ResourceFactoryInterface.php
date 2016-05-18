<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Resource;

interface ResourceFactoryInterface
{
    /**
     * Get a new resource with path
     *
     * @param string $path
     * @return Resource
     */
    public function getInstance(string $path): Resource;
}
