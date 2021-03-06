<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Model\Traits;

use Fxp\Component\Security\Model\OrganizationInterface;
use Fxp\Component\Security\Model\Traits\OrganizationalOptionalTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class OrganizationalOptionalTraitTest extends TestCase
{
    /**
     * @throws
     */
    public function testModel(): void
    {
        /** @var OrganizationInterface $org */
        $org = $this->getMockBuilder(OrganizationInterface::class)->getMock();

        /** @var OrganizationalOptionalTrait $model */
        $model = $this->getMockForTrait(OrganizationalOptionalTrait::class);
        $model->setOrganization($org);

        static::assertSame($org, $model->getOrganization());

        $model->setOrganization(null);
        static::assertNull($model->getOrganization());
    }
}
