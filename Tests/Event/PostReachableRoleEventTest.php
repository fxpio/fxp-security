<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Event;

use Fxp\Component\Security\Event\PostReachableRoleEvent;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PostReachableRoleEventTest extends TestCase
{
    public function testEvent()
    {
        $roles = [
            'ROLE_FOO',
            'ROLE_BAR',
        ];

        $event = new PostReachableRoleEvent($roles);
        $this->assertSame($roles, $event->getReachableRoles());
        $this->assertTrue($event->isPermissionEnabled());

        $roles[] = 'ROLE_BAZ';
        $event->setReachableRoles($roles);
        $this->assertSame($roles, $event->getReachableRoles());
    }
}
