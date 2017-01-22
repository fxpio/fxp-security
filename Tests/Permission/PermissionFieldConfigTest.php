<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Security\Tests\Permission;

use Sonatra\Component\Security\Permission\PermissionFieldConfig;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class PermissionFieldConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testPermissionFieldConfigByDefault()
    {
        $config = new PermissionFieldConfig('foo');

        $this->assertSame('foo', $config->getField());
        $this->assertSame(array(), $config->getOperations());
        $this->assertFalse($config->hasOperation('foo'));
    }

    public function testPermissionFieldConfig()
    {
        $operations = array('read', 'edit');
        $alias = array(
            'test' => 'read',
        );
        $config = new PermissionFieldConfig('foo', $operations, $alias);

        $this->assertSame('foo', $config->getField());
        $this->assertSame($operations, $config->getOperations());
        $this->assertTrue($config->hasOperation('read'));
        $this->assertFalse($config->hasOperation('foo'));
        $this->assertSame($alias, $config->getMappingPermissions());
        $this->assertTrue($config->hasOperation('test'));
    }
}
