<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Entity;

use InvalidArgumentException;

class Resource
{
    /**
     * Example paths:
     *
     * - Static: /hello/world
     * - Dynamic: /hello/name:[A-Za-z]+
     *
     * @var string
     */
    private $path;

    /**
     * The workable path
     *
     * @var string
     */
    private $compiled;

    /**
     * The names of the dynamic params
     *
     * @var string[]
     */
    private $params;

    /**
     * @var string
     */
    const TRIM_CHARS = '/';

    /**
     * @var string
     */
    const PART_SEP = '/';

    /**
     * @var string
     */
    const PATTERN_SEP = ':';

    public function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @throws InvalidArgumentException
     * @param string $path
     * @return Resource
     */
    public function setPath(string $path): Resource
    {
        if ($path == '') {
            throw new InvalidArgumentException('The path used for a resource cannot be empty.');
        }

        $this->path = $this->trimPath($path);

        $this->compilePath();

        return $this;
    }

    /**
     * Prepends a path to the existing path
     *
     * @param string $prefix The prefix to be added
     * @return Resource
     */
    public function withPrefix(string $prefix): Resource
    {
        $this->path = $this->trimPath($prefix) . self::PART_SEP . $this->path;

        $this->compilePath();

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCompiledPath(): string
    {
        return $this->compiled;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function isDynamic(): bool
    {
        return count($this->params) > 0;
    }

    /**
     * Creates the matchable regex path for the route matcher
     */
    private function compilePath()
    {
        $pattern = '';
        $this->params = [];

        $parts = explode(self::PART_SEP, $this->path);

        foreach($parts as $part) {
            $data = explode(self::PATTERN_SEP, $part);

            if (count($data) == 2) {
                $this->params[] = $data[0];
               $pattern .= self::PART_SEP . '(' . $data[1] . ')';
            } else {
               $pattern .= self::PART_SEP . $data[0];
            }
        }

        $this->compiled = '^' . $this->trimPath($pattern) . '$';
    }

    /**
     * Removes bad characters from the beginning and end of the path
     *
     * @param string $path The path to be trimmed
     */
    private function trimPath(string $path)
    {
        return trim($path, self::TRIM_CHARS);
    }
}