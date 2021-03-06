<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Model;

use Fxp\Component\Security\Model\OrganizationInterface;
use Fxp\Component\Security\Model\UserInterface;
use Fxp\Component\Security\Tests\Fixtures\Model\MockOrganizationUser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class OrganizationUserTest extends TestCase
{
    public function testModel(): void
    {
        /** @var MockObject|OrganizationInterface $org */
        $org = $this->getMockBuilder(OrganizationInterface::class)->getMock();
        $org->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('foo')
        ;

        /** @var MockObject|UserInterface $user */
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $user->expects(static::atLeastOnce())
            ->method('getUsername')
            ->willReturn('user.test')
        ;

        $orgUser = new MockOrganizationUser($org, $user);

        static::assertSame(42, $orgUser->getId());
        static::assertSame($org, $orgUser->getOrganization());
        static::assertSame($user, $orgUser->getUser());

        static::assertSame('foo:user.test', (string) $orgUser);

        /** @var MockObject|OrganizationInterface $org2 */
        $org2 = $this->getMockBuilder(OrganizationInterface::class)->getMock();

        $orgUser->setOrganization($org2);

        static::assertNotSame($org, $orgUser->getOrganization());
        static::assertSame($org2, $orgUser->getOrganization());

        /** @var MockObject|UserInterface $user2 */
        $user2 = $this->getMockBuilder(UserInterface::class)->getMock();

        $orgUser->setUser($user2);

        static::assertNotSame($user, $orgUser->getUser());
        static::assertSame($user2, $orgUser->getUser());
    }
}
