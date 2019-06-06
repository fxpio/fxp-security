<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Doctrine\ORM\Filter;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\FilterCollection;
use Fxp\Component\Security\Doctrine\ORM\Event\GetPrivateFilterEvent;
use Fxp\Component\Security\Doctrine\ORM\Filter\SharingFilter;
use Fxp\Component\Security\Identity\SubjectIdentity;
use Fxp\Component\Security\Sharing\SharingManagerInterface;
use Fxp\Component\Security\SharingVisibilities;
use Fxp\Component\Security\Tests\Fixtures\Model\MockObject;
use Fxp\Component\Security\Tests\Fixtures\Model\MockSharing;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SharingFilterTest extends TestCase
{
    /**
     * @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $em;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|SharingManagerInterface
     */
    protected $sharingManager;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected $sharingClass;

    /**
     * @var ClassMetadata|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $targetEntity;

    /**
     * @var SharingFilter
     */
    protected $filter;

    /**
     * @throws
     */
    protected function setUp(): void
    {
        $this->em = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
        $this->eventManager = new EventManager();
        $this->sharingManager = $this->getMockBuilder(SharingManagerInterface::class)->getMock();
        $this->eventDispatcher = new EventDispatcher();
        $this->sharingClass = MockSharing::class;
        $this->targetEntity = $this->getMockBuilder(ClassMetadata::class)->disableOriginalConstructor()->setMethods([
            'getName',
        ])->getMock();
        $this->filter = new SharingFilter($this->em);

        $connection = $this->getMockBuilder(Connection::class)->getMock();

        $this->em->expects($this->any())
            ->method('getEventManager')
            ->willReturn($this->eventManager)
        ;

        $this->em->expects($this->any())
            ->method('getFilters')
            ->willReturn(new FilterCollection($this->em))
        ;

        $this->em->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection)
        ;

        $connection->expects($this->any())
            ->method('quote')
            ->willReturnCallback(static function ($v) {
                return '\''.$v.'\'';
            })
        ;

        $this->targetEntity->expects($this->any())
            ->method('getName')
            ->willReturn(MockObject::class)
        ;
    }

    public function testAddFilterConstraintWithoutSupports(): void
    {
        $this->eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $this->eventDispatcher->expects($this->never())
            ->method('dispatch')
        ;

        $this->filter->addFilterConstraint($this->targetEntity, 't');
    }

    public function testAddFilterConstraint(): void
    {
        $this->filter->setSharingManager($this->sharingManager);
        $this->filter->setSharingClass($this->sharingClass);
        $this->filter->setEventDispatcher($this->eventDispatcher);
        $this->filter->setParameter('has_security_identities', true, 'boolean');
        $this->filter->setParameter('map_security_identities', [], 'array');
        $this->filter->setParameter('user_id', 42, 'integer');
        $this->filter->setParameter('sharing_manager_enabled', true, 'boolean');

        $this->eventDispatcher->addListener(
            GetPrivateFilterEvent::class,
            static function (GetPrivateFilterEvent $event): void {
                $event->setFilterConstraint('FILTER_TEST');
            }
        );

        $this->sharingManager->expects($this->once())
            ->method('hasSharingVisibility')
            ->with(SubjectIdentity::fromClassname(MockObject::class))
            ->willReturn(true)
        ;

        $this->sharingManager->expects($this->once())
            ->method('getSharingVisibility')
            ->with(SubjectIdentity::fromClassname(MockObject::class))
            ->willReturn(SharingVisibilities::TYPE_PRIVATE)
        ;

        $this->assertSame('FILTER_TEST', $this->filter->addFilterConstraint($this->targetEntity, 't'));
    }
}
