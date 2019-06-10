<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Configuration;

use Fxp\Component\Security\Configuration\SharingSubject;
use Fxp\Component\Security\SharingVisibilities;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SharingSubjectTest extends TestCase
{
    public function testConstructor(): void
    {
        $config = new SharingSubject([
            'visibility' => SharingVisibilities::TYPE_PUBLIC,
        ]);

        $this->assertSame(SharingVisibilities::TYPE_PUBLIC, $config->getVisibility());
    }
}
