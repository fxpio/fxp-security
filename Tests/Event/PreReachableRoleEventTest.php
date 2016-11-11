<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Security\Tests\Event;

use Sonatra\Component\Security\Event\PreReachableRoleEvent;
use Symfony\Component\Security\Core\Role\Role;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class PreReachableRoleEventTest extends \PHPUnit_Framework_TestCase
{
    public function testEvent()
    {
        $roles = array(
            new Role('ROLE_FOO'),
            new Role('ROLE_BAR'),
        );

        $event = new PreReachableRoleEvent($roles);
        $this->assertSame($roles, $event->getReachableRoles());
        $this->assertTrue($event->isAclEnabled());

        $roles[] = new Role('ROLE_BAZ');
        $event->setReachableRoles($roles);
        $event->setAclEnabled(false);
        $this->assertSame($roles, $event->getReachableRoles());
        $this->assertFalse($event->isAclEnabled());
    }
}