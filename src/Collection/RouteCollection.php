<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Collection;

use AlecGunnar\HttpRouter\Entity\Resource;
use AlecGunnar\HttpRouter\Entity\Route;
use InvalidArgumentException;

class RouteCollection implements RouteCollectionInterface
{
    use RouteCollectionTrait;
}
