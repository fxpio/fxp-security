<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Security\Sharing\Loader;

use Fxp\Component\Security\Sharing\SharingSubjectConfigCollection;
use Fxp\Component\Security\Sharing\SharingSubjectConfigInterface;
use Symfony\Component\Config\Loader\Loader;

/**
 * Sharing subject configuration loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class SubjectConfigurationLoader extends Loader
{
    /**
     * @var SharingSubjectConfigCollection
     */
    protected $configs;

    /**
     * Constructor.
     *
     * @param SharingSubjectConfigInterface[] $configs The sharing subject configs
     */
    public function __construct(array $configs = [])
    {
        $this->configs = new SharingSubjectConfigCollection();

        foreach ($configs as $config) {
            $this->configs->add($config);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null): SharingSubjectConfigCollection
    {
        return $this->configs;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null): bool
    {
        return 'config' === $type;
    }
}
