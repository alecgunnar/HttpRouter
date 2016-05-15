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
    private $route;

    /**
     * Was the method of the route matched too?
     *
     * @var bool
     */
    private $methodToo;

    /**
     * Any dynamic params taken from the resource name
     *
     * @var array
     */
    private $params;

    /**
     * @param Route $matched The matched route
     * @param array $params=[] Params from dynamic parts of resource name
     */
    public function __construct(Route $route, bool $methodToo=true, array $params=[])
    {
        $this->route = $route;
        $this->methodToo = $methodToo;
        $this->params = $params;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getMethodToo(): bool
    {
        return $this->methodToo;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
