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

use Doctrine\Common\Collections\Collection;

/**
 * Organization interface.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface OrganizationInterface
{
    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * Get the id of model.
     *
     * @return null|int|string
     */
    public function getId();

    /**
     * Set the name.
     *
     * @param string $name The name
     *
     * @return static
     */
    public function setName(?string $name);

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName(): ?string;

    /**
     * Set the user of organization.
     *
     * @param null|UserInterface $user The user of organization
     *
     * @return static
     */
    public function setUser(?UserInterface $user);

    /**
     * Get the user of organization.
     *
     * @return UserInterface
     */
    public function getUser(): ?UserInterface;

    /**
     * Check if the organization is a dedicated organization for the user.
     *
     * @return bool
     */
    public function isUserOrganization(): bool;

    /**
     * Get the users of organization.
     *
     * @return Collection|OrganizationUserInterface[]
     */
    public function getOrganizationUsers();

    /**
     * Get the usernames of organization.
     *
     * @return string[]
     */
    public function getOrganizationUserNames(): array;

    /**
     * Check the presence of username in organization.
     *
     * @param string $username The username
     *
     * @return bool
     */
    public function hasOrganizationUser(string $username): bool;

    /**
     * Add a organization user in organization.
     *
     * @param OrganizationUserInterface $organizationUser The organization user
     *
     * @return static
     */
    public function addOrganizationUser(OrganizationUserInterface $organizationUser);

    /**
     * Remove a organization user in organization.
     *
     * @param OrganizationUserInterface $organizationUser The organization user
     *
     * @return static
     */
    public function removeOrganizationUser(OrganizationUserInterface $organizationUser);
}
