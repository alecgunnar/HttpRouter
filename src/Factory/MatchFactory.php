<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Match;

class MatchFactory implements MatchFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getInstance(Route $route, array $params=[]): Match
    {
        return new Match($route, $params);
    }
}
