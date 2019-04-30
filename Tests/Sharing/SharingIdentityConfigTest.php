<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Sharing;

use Fxp\Component\Security\Sharing\SharingIdentityConfig;
use Fxp\Component\Security\Tests\Fixtures\Model\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SharingIdentityConfigTest extends TestCase
{
    public function testSharingIdentityConfigByDefault(): void
    {
        $config = new SharingIdentityConfig(MockObject::class);

        $this->assertSame(MockObject::class, $config->getType());
        $this->assertSame('mockobject', $config->getAlias());
        $this->assertFalse($config->isRoleable());
        $this->assertFalse($config->isPermissible());
    }

    public function testSharingIdentityConfig(): void
    {
        $config = new SharingIdentityConfig(MockObject::class, 'mock_object', true, true);

        $this->assertSame(MockObject::class, $config->getType());
        $this->assertSame('mock_object', $config->getAlias());
        $this->assertTrue($config->isRoleable());
        $this->assertTrue($config->isPermissible());
    }
}
