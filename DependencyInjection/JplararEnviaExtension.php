<?php

namespace Jplarar\EnviaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JplararEnviaExtension extends Extension
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

        if (!isset($config['envia_token'])) {
            throw new \InvalidArgumentException(
                'The option "jplarar_envia.envia_token" must be set.'
            );
        }

        $container->setParameter(
            'jplarar_envia.envia_token',
            $config['envia_token']
        );

        if (!isset($config['envia_environment'])) {
            throw new \InvalidArgumentException(
                'The option "jplarar_envia.envia_environment" must be set.'
            );
        }

        $container->setParameter(
            'jplarar_envia.envia_environment',
            $config['envia_environment']
        );
    }

    /**
     * {@inheritdoc}
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getAlias()
    {
        return 'jplarar_envia';
    }
}
