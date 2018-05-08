<?php

namespace Jplarar\EnviapaqueteriaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JplararEnviapaqueteriaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!isset($config['enviapaqueteria_keys']['enviapaqueteria_user'])) {
            throw new \InvalidArgumentException(
                'The option "jplarar_enviapaqueteria.enviapaqueteria_keys.enviapaqueteria_user" must be set.'
            );
        }

        $container->setParameter(
            'jplarar_enviapaqueteria.enviapaqueteria_keys.enviapaqueteria_user',
            $config['enviapaqueteria_keys']['enviapaqueteria_user']
        );

        if (!isset($config['enviapaqueteria_keys']['enviapaqueteria_password'])) {
            throw new \InvalidArgumentException(
                'The option "jplarar_enviapaqueteria.enviapaqueteria_keys.enviapaqueteria_password" must be set.'
            );
        }

        $container->setParameter(
            'jplarar_enviapaqueteria.enviapaqueteria_keys.enviapaqueteria_password',
            $config['enviapaqueteria_keys']['enviapaqueteria_password']
        );

        if (!isset($config['enviapaqueteria_keys']['enviapaqueteria_environment'])) {
            throw new \InvalidArgumentException(
                'The option "jplarar_enviapaqueteria.enviapaqueteria_keys.enviapaqueteria_environment" must be set.'
            );
        }

        $container->setParameter(
            'jplarar_enviapaqueteria.enviapaqueteria_keys.enviapaqueteria_environment',
            $config['enviapaqueteria_keys']['enviapaqueteria_environment']
        );
    }

    /**
     * {@inheritdoc}
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getAlias()
    {
        return 'jplarar_enviapaqueteria';
    }
}
