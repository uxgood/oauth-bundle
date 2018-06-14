<?php

namespace UxGood\Bundle\OAuthBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

class OAuthFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $builder = $node->children();
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'oauth';
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return 'http';
    }

    /**
     * {@inheritdoc}
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $provider = 'uxgood_oauth.authentication.provider.oauth.'.$id;

        $container
            ->setDefinition($provider, new ChildDefinition('uxgood_oauth.authentication.provider.oauth'))
            ->addArgument(new Reference('security.user_checker'))
            ->addArgument(new Reference('security.token_storage'))
        ;

        return $provider;
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'uxgood_oauth.authentication.entry_point.oauth.'.$id;

        $container
            ->setDefinition($entryPointId, new ChildDefinition('uxgood_oauth.authentication.entry_point.oauth'))
            ->addArgument($config['login_path'])
            ->addArgument($config['use_forward'])
        ;

        return $entryPointId;
    }

    /**
     * {@inheritdoc}
     */
    protected function createListener($container, $id, $config, $userProvider)
    {
        $listenerId = parent::createListener($container, $id, $config, $userProvider);

        return $listenerId;
    }

    /**
     * {@inheritdoc}
     */
    protected function getListenerId()
    {
        return 'uxgood_oauth.authentication.listener.oauth';
    }
}
