<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Model;

use Fxp\Component\Security\Model\Traits\PermissionsInterface;
use Fxp\Component\Security\Model\Traits\RoleableInterface;

/**
 * Sharing interface.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface SharingInterface extends PermissionsInterface, RoleableInterface
{
    /**
     * Get the id.
     *
     * @return null|int|string
     */
    public function getId();

    /**
     * Set the classname of subject.
     *
     * @param null|string $class The classname
     *
     * @return self
     */
    public function setSubjectClass($class);

    /**
     * Get the classname of subject.
     *
     * @return null|string
     */
    public function getSubjectClass();

    /**
     * Set the id of subject.
     *
     * @param int|string $id The id
     *
     * @return self
     */
    public function setSubjectId($id);

    /**
     * Get the id of subject.
     *
     * @return int|string
     */
    public function getSubjectId();

    /**
     * Set the classname of identity.
     *
     * @param null|string $class The classname
     *
     * @return self
     */
    public function setIdentityClass($class);

    /**
     * Get the classname of identity.
     *
     * @return null|string
     */
    public function getIdentityClass();

    /**
     * Set the unique name of identity.
     *
     * @param string $name The unique name
     *
     * @return self
     */
    public function setIdentityName($name);

    /**
     * Get the unique name of identity.
     *
     * @return string
     */
    public function getIdentityName();

    /**
     * Define if the sharing entry is enabled.
     *
     * @param bool $enabled The value
     *
     * @return self
     */
    public function setEnabled($enabled);

    /**
     * Check if the sharing entry is enabled.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Set the date when the sharing entry must start.
     *
     * @param null|\DateTime $date The date
     *
     * @return self
     */
    public function setStartedAt($date);

    /**
     * Get the date when the sharing entry must start.
     *
     * @return null|\DateTime
     */
    public function getStartedAt();

    /**
     * Set the date when the sharing entry must end.
     *
     * @param null|\DateTime $date The date
     *
     * @return self
     */
    public function setEndedAt($date);

    /**
     * Get the date when the sharing entry must end.
     *
     * @return null|\DateTime
     */
    public function getEndedAt();
}
