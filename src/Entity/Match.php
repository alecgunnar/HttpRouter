<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Entity;

class Match
{
    /**
     * The route which was matched
     *
     * @var Route
     */
    protected $route;

    /**
     * Any dynamic params taken from the resource name
     *
     * @var array
     */
    protected $params;

    /**
     * @param Route $route The matched route
     * @param array $params=[] Params from dynamic parts of resource name
     */
    public function __construct(Route $route, array $params=[])
    {
        $this->route = $route;
        $this->params = $params;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
