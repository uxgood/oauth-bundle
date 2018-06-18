<?php

namespace UxGood\Bundle\OAuthBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class UxGoodOAuthExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
        $this->createHttpMethodsClient($container, $config);
    }

    /**
    |* {@inheritdoc}
    |*/
    public function getAlias()
    {
        return 'uxgood_oauth';
    }

    private function createHttpMethodsClient(ContainerBuilder $container, array $config)
    {
        $httpClientId = $config['http']['client'];
        $container->setAlias('uxgood_oauth.http.client.default', new Alias($httpClientId));
    }
}
