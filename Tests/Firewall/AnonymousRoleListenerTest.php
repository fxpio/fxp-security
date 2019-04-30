<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Firewall;

use Fxp\Component\Security\Firewall\AnonymousRoleListener;
use Fxp\Component\Security\Identity\SecurityIdentityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class AnonymousRoleListenerTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SecurityIdentityManagerInterface
     */
    protected $sidManager;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var AuthenticationTrustResolverInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $trustResolver;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Request
     */
    protected $request;

    /**
     * @var GetResponseEvent|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $event;

    /**
     * @var AnonymousRoleListener
     */
    protected $listener;

    protected function setUp(): void
    {
        $this->sidManager = $this->getMockBuilder(SecurityIdentityManagerInterface::class)->getMock();
        $this->config = [
            'role' => 'ROLE_CUSTOM_ANONYMOUS',
        ];
        $this->trustResolver = $this->getMockBuilder(AuthenticationTrustResolverInterface::class)->getMock();
        $this->tokenStorage = $this->getMockBuilder(TokenStorageInterface::class)->getMock();
        $this->request = $this->getMockBuilder(Request::class)->getMock();
        $this->event = $this->getMockBuilder(GetResponseEvent::class)->disableOriginalConstructor()->getMock();
        $this->event->expects($this->any())
            ->method('getRequest')
            ->willReturn($this->request)
        ;

        $this->listener = new AnonymousRoleListener(
            $this->sidManager,
            $this->config,
            $this->trustResolver,
            $this->tokenStorage
        );
    }

    public function testBasic(): void
    {
        $this->assertTrue($this->listener->isEnabled());
        $this->listener->setEnabled(false);
        $this->assertFalse($this->listener->isEnabled());
    }

    public function testHandleWithDisabledListener(): void
    {
        $this->sidManager->expects($this->never())
            ->method('addSpecialRole')
        ;

        $this->tokenStorage->expects($this->never())
            ->method('getToken')
        ;

        $this->trustResolver->expects($this->never())
            ->method('isAnonymous')
        ;

        $this->listener->setEnabled(false);
        $this->listener->handle($this->event);
    }

    public function testHandleWithoutAnonymousRole(): void
    {
        $this->listener = new AnonymousRoleListener(
            $this->sidManager,
            [
                'role' => null,
            ],
            $this->trustResolver,
            $this->tokenStorage
        );

        $this->sidManager->expects($this->never())
            ->method('addSpecialRole')
        ;

        $this->tokenStorage->expects($this->never())
            ->method('getToken')
        ;

        $this->trustResolver->expects($this->never())
            ->method('isAnonymous')
        ;

        $this->listener->handle($this->event);
    }

    public function testHandleWithoutToken(): void
    {
        $this->tokenStorage->expects($this->once())
            ->method('getToken')
            ->willReturn(null)
        ;

        $this->trustResolver->expects($this->never())
            ->method('isAnonymous')
        ;

        $this->sidManager->expects($this->once())
            ->method('addSpecialRole')
            ->with('ROLE_CUSTOM_ANONYMOUS')
        ;

        $this->listener->handle($this->event);
    }

    public function testHandleWithToken(): void
    {
        $token = $this->getMockBuilder(TokenInterface::class)->getMock();

        $this->tokenStorage->expects($this->once())
            ->method('getToken')
            ->willReturn($token)
        ;

        $this->trustResolver->expects($this->once())
            ->method('isAnonymous')
            ->with($token)
            ->willReturn(true)
        ;

        $this->sidManager->expects($this->once())
            ->method('addSpecialRole')
            ->with('ROLE_CUSTOM_ANONYMOUS')
        ;

        $this->listener->handle($this->event);
    }
}
