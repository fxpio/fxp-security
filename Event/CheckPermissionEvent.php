<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Event;

use Fxp\Component\Security\Identity\SecurityIdentityInterface;
use Fxp\Component\Security\Identity\SubjectIdentityInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The check permission event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class CheckPermissionEvent extends Event
{
    /**
     * @var SecurityIdentityInterface[]
     */
    protected $sids;

    /**
     * @var array
     */
    protected $permissionMap;

    /**
     * @var string
     */
    protected $operation;

    /**
     * @var null|SubjectIdentityInterface
     */
    protected $subject;

    /**
     * @var null|string
     */
    protected $field;

    /**
     * @var null|bool
     */
    protected $granted;

    /**
     * Constructor.
     *
     * @param SecurityIdentityInterface[]   $sids          The security identities
     * @param array                         $permissionMap The map of permissions
     * @param string                        $operation     The operation
     * @param null|SubjectIdentityInterface $subject       The subject
     * @param null|string                   $field         The field of subject
     */
    public function __construct(
        array $sids,
        array $permissionMap,
        string $operation,
        ?SubjectIdentityInterface $subject = null,
        ?string $field = null
    ) {
        $this->sids = $sids;
        $this->permissionMap = $permissionMap;
        $this->operation = $operation;
        $this->subject = $subject;
        $this->field = $field;
    }

    /**
     * Get the security identities.
     *
     * @return SecurityIdentityInterface[]
     */
    public function getSecurityIdentities(): array
    {
        return $this->sids;
    }

    /**
     * Get the map of permissions.
     *
     * @return array
     */
    public function getPermissionMap(): array
    {
        return $this->permissionMap;
    }

    /**
     * Get the operation.
     *
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * Get the subject.
     *
     * @return null|SubjectIdentityInterface
     */
    public function getSubject(): ?SubjectIdentityInterface
    {
        return $this->subject;
    }

    /**
     * Get the field.
     *
     * @return null|string
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Define the granted value.
     *
     * @param null|bool $granted The granted value
     *
     * @return static
     */
    public function setGranted(?bool $granted): self
    {
        $this->granted = $granted;

        return $this;
    }

    /**
     * Check if the permission is granted or not.
     *
     * @return null|bool
     */
    public function isGranted(): ?bool
    {
        return $this->granted;
    }
}
