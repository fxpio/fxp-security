<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Security\Model\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sonatra\Component\Security\Model\PermissionInterface;

/**
 * Trait of model with permissions.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
trait PermissionsTrait
{
    /**
     * @var Collection|PermissionInterface[]|null
     */
    protected $permissions;

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        return $this->permissions ?: $this->permissions = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission(PermissionInterface $permission)
    {
        return $this->getPermissions()->contains($permission);
    }

    /**
     * {@inheritdoc}
     */
    public function addPermission(PermissionInterface $permission)
    {
        if (!$this->getPermissions()->contains($permission)) {
            $this->getPermissions()->add($permission);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePermission(PermissionInterface $permission)
    {
        if ($this->getPermissions()->contains($permission)) {
            $this->getPermissions()->removeElement($permission);
        }

        return $this;
    }
}
