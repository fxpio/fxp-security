<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Fixtures\Model;

use Fxp\Component\Security\Model\Traits\OrganizationGroupsInterface;
use Fxp\Component\Security\Model\Traits\OrganizationGroupsTrait;
use Fxp\Component\Security\Model\Traits\OrganizationRolesInterface;
use Fxp\Component\Security\Model\Traits\OrganizationRolesTrait;
use Fxp\Component\Security\Model\Traits\OrganizationTrait;
use Fxp\Component\Security\Model\Traits\RoleableInterface;
use Fxp\Component\Security\Model\Traits\RoleableTrait;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MockOrganization implements RoleableInterface, OrganizationRolesInterface, OrganizationGroupsInterface
{
    use OrganizationTrait;
    use RoleableTrait;
    use OrganizationRolesTrait;
    use OrganizationGroupsTrait;

    /**
     * @var null|int
     */
    protected $id;

    /**
     * Constructor.
     *
     * @param string $name The unique name
     * @param int    $id   The id
     */
    public function __construct(string $name, int $id = 23)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
