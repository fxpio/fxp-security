<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Security\Tests\Fixtures\Model;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class MockObject
{
    /**
     * @var int|string|null
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param string          $name The name
     * @param int|string|null $id   The id
     */
    public function __construct($name, $id = 42)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name.
     *
     * @param string $name The name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
