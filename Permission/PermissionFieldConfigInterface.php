<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Security\Permission;

/**
 * Permission field config Interface.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface PermissionFieldConfigInterface
{
    /**
     * Get the field name.
     *
     * @return string
     */
    public function getField();

    /**
     * Check if the operation is defined.
     *
     * @param string $operation The operation name
     *
     * @return bool
     */
    public function hasOperation($operation);

    /**
     * Get the available operations.
     *
     * @return string[]
     */
    public function getOperations();
}
