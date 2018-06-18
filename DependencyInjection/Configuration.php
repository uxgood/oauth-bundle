<?php

namespace UxGood\Bundle\OAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('uxgood_oauth');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $this->addHttpClientConfiguration($rootNode);
        $this->addFirewallConfiguration($rootNode);

        return $treeBuilder;
    }

    private function addFirewallConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->fixXmlConfig('firewall')
            ->children()
                ->arrayNode('firewalls')
                //->isRequired()
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->ignoreExtraKeys()
                    ->children()
                        ->arrayNode('oauth_helpers')
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->ignoreExtraKeys()
                            ->children()
                            ->scalarNode('base_url')->end()
                            ->scalarNode('access_token_url')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('authorization_url')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('request_token_url')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('revoke_token_url')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('user_info_url')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('client_id')->cannotBeEmpty()->end()
                            ->scalarNode('client_secret')->cannotBeEmpty()->end()
                            ->scalarNode('scope')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('realm')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('decoder')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('helper')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->scalarNode('use_comma')
                                ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                            ->end()
                            ->arrayNode('key_maps')
                                ->useAttributeAsKey('name')
                                ->prototype('variable')
                                    ->validate()->ifTrue(function($v) { return empty($v); })->thenUnset()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addHttpClientConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('http')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('client')->defaultValue('uxgood_oauth.http.client.simple')->end()
                ->end()
            ->end()
        ;
    }
}
