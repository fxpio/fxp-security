<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Authentication\Provider;

use Fxp\Component\Security\Authentication\Provider\AnonymousRoleProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class AnonymousRoleProviderTest extends TestCase
{
    public function testBasic(): void
    {
        /** @var TokenInterface $token */
        $token = $this->getMockBuilder(TokenInterface::class)->getMock();
        $provider = new AnonymousRoleProvider();

        static::assertSame($token, $provider->authenticate($token));
        static::assertFalse($provider->supports($token));
    }
}
