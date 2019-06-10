<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Tests\Fixtures\Model;

use Fxp\Component\Security\Configuration as FxpSecurity;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MockObjectWithOnlyFieldAnnotation extends MockObject
{
    /**
     * @var string
     *
     * @FxpSecurity\PermissionField(operations={"read", "edit"})
     */
    protected $name;
}
