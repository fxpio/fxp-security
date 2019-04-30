<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Expression;

use Fxp\Component\Security\Event\GetExpressionVariablesEvent;
use Fxp\Component\Security\Expression\ExpressionVariableStorage;
use Fxp\Component\Security\Identity\RoleSecurityIdentity;
use Fxp\Component\Security\Identity\SecurityIdentityManagerInterface;
use Fxp\Component\Security\Model\RoleInterface;
use Fxp\Component\Security\Organizational\OrganizationalContextInterface;
use Fxp\Component\Security\Role\RoleUtil;
use Fxp\Component\Security\Tests\Fixtures\Model\MockRole;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 * @coversNothing
 */
final class ExpressionVariableStorageTest extends TestCase
{
    /**
     * @var AuthenticationTrustResolverInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $trustResolver;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SecurityIdentityManagerInterface
     */
    protected $sidManager;

    /**
     * @var OrganizationalContextInterface
     */
    protected $context;

    /**
     * @var RoleInterface
     */
    protected $orgRole;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TokenInterface
     */
    protected $token;

    protected function setUp(): void
    {
        $this->trustResolver = $this->getMockBuilder(AuthenticationTrustResolverInterface::class)->getMock();
        $this->sidManager = $this->getMockBuilder(SecurityIdentityManagerInterface::class)->getMock();
        $this->token = $this->getMockBuilder(TokenInterface::class)->getMock();
    }

    public function testSetVariablesWithSecurityIdentityManager(): void
    {
        $event = new GetExpressionVariablesEvent($this->token);
        $sids = [
            new RoleSecurityIdentity(MockRole::class, 'ROLE_USER'),
            new RoleSecurityIdentity('role', AuthenticatedVoter::IS_AUTHENTICATED_FULLY),
        ];

        $this->token->expects($this->never())
            ->method('getRoles')
        ;

        $this->sidManager->expects($this->once())
            ->method('getSecurityIdentities')
            ->with($this->token)
            ->willReturn($sids)
        ;

        $variableStorage = new ExpressionVariableStorage(
            [
                'organizational_context' => $this->context,
                'organizational_role' => $this->orgRole,
            ],
            $this->sidManager
        );
        $variableStorage->add('trust_resolver', $this->trustResolver);
        $variableStorage->inject($event);

        $variables = $event->getVariables();
        $this->assertCount(6, $variables);
        $this->assertArrayHasKey('token', $variables);
        $this->assertArrayHasKey('user', $variables);
        $this->assertArrayHasKey('roles', $variables);
        $this->assertArrayHasKey('trust_resolver', $variables);
        $this->assertArrayHasKey('organizational_context', $variables);
        $this->assertArrayHasKey('organizational_role', $variables);
        $this->assertEquals(['ROLE_USER'], $variables['roles']);
        $this->assertCount(1, ExpressionVariableStorage::getSubscribedEvents());
    }

    public function testSetVariablesWithoutSecurityIdentityManager(): void
    {
        $this->token->expects($this->once())
            ->method('getRoles')
            ->willReturn([
                RoleUtil::formatRole('ROLE_USER'),
            ])
        ;

        $event = new GetExpressionVariablesEvent($this->token);
        $variableStorage = new ExpressionVariableStorage();
        $variableStorage->add('trust_resolver', $this->trustResolver);
        $variableStorage->inject($event);

        $variables = $event->getVariables();
        $this->assertCount(4, $variables);
        $this->assertArrayHasKey('token', $variables);
        $this->assertArrayHasKey('user', $variables);
        $this->assertArrayHasKey('roles', $variables);
        $this->assertArrayHasKey('trust_resolver', $variables);
        $this->assertEquals(['ROLE_USER'], $variables['roles']);
        $this->assertCount(1, ExpressionVariableStorage::getSubscribedEvents());
    }

    public function testHasVariable(): void
    {
        $variableStorage = new ExpressionVariableStorage([
            'foo' => 'bar',
        ]);

        $this->assertFalse($variableStorage->has('bar'));
        $this->assertTrue($variableStorage->has('foo'));
    }

    public function testAddVariable(): void
    {
        $variableStorage = new ExpressionVariableStorage();

        $this->assertFalse($variableStorage->has('foo'));
        $this->assertNull($variableStorage->get('foo'));

        $variableStorage->add('foo', 'bar');

        $this->assertTrue($variableStorage->has('foo'));
        $this->assertSame('bar', $variableStorage->get('foo'));
        $this->assertCount(1, $variableStorage->getAll());
    }

    public function testRemoveVariable(): void
    {
        $variableStorage = new ExpressionVariableStorage([
            'foo' => 'bar',
        ]);

        $this->assertTrue($variableStorage->has('foo'));

        $variableStorage->remove('foo');

        $this->assertFalse($variableStorage->has('foo'));
    }
}
