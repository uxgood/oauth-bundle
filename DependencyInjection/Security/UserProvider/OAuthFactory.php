<?php

namespace UxGood\Bundle\OAuthBundle\DependencyInjection\Security\UserProvider;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\UserProvider\UserProviderFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OAuthFactory implements UserProviderFactoryInterface
{

    public function create(ContainerBuilder $container, $id, $config)
    {
        $definition = $container->setDefinition($id, new ChildDefinition('uxgood_oauth.user.provider.oauth'));
    }

    public function getKey()
    {
        return 'oauth';
    }


    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('class')->defaultNull()->end()
                ->scalarNode('property')->defaultNull()->end()
            ->end()
        ;
    }
}
