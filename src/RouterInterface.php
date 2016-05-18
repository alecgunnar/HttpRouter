<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter;

use Psr\Http\Message\ServerRequestInterface;
use AlecGunnar\HttpRouter\Entity\Match;

interface RouterInterface
{
    /**
     * Add a.
     */

    /**
     * Gets all of the routes whose resource's path matches the given request's uri's path.
     *
     * @param ServerRequestInterface $request The request to be matched
     *
     * @return Match|bool
     */
    public function getMatch(ServerRequestInterface $request): Match;
}
