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

use Doctrine\Common\Collections\Collection;
use Fxp\Component\Security\PermissionContexts;
use Fxp\Component\Security\Tests\Fixtures\Model\MockObject;
use Fxp\Component\Security\Tests\Fixtures\Model\MockPermission;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class PermissionTest extends TestCase
{
    public function testModel(): void
    {
        $perm = new MockPermission();
        $perm->setOperation('foo');
        $perm->setClass(MockObject::class);
        $perm->setField('name');
        $perm->setContexts([PermissionContexts::ROLE]);

        $this->assertNull($perm->getId());
        $this->assertSame('foo', $perm->getOperation());
        $this->assertSame(MockObject::class, $perm->getClass());
        $this->assertSame('name', $perm->getField());
        $this->assertSame([PermissionContexts::ROLE], $perm->getContexts());
        $this->assertInstanceOf(Collection::class, $perm->getRoles());
    }
}
