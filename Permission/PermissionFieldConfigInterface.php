<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Permission;

/**
 * Permission field config Interface.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface PermissionFieldConfigInterface
{
    /**
     * Get the field name.
     *
     * @return string
     */
    public function getField(): string;

    /**
     * Check if the operation is defined.
     *
     * @param string $operation The operation name
     *
     * @return bool
     */
    public function hasOperation(string $operation): bool;

    /**
     * Get the available operations.
     *
     * @return string[]
     */
    public function getOperations(): array;

    /**
     * Check if the field permission is editable.
     *
     * @return bool
     */
    public function isEditable(): bool;

    /**
     * Get the real permission associated with the alias permission.
     *
     * Example: [
     *     'create' => 'invite',
     *     'delete' => 'revoke',
     * ]
     *
     * @param string $aliasPermission The operation or alias of operation
     *
     * @return string
     */
    public function getMappingPermission(string $aliasPermission): string;

    /**
     * Get the map of alias permission and real permission.
     *
     * @return string[]
     */
    public function getMappingPermissions(): array;
}
