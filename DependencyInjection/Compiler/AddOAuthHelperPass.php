<?php
namespace UxGood\Bundle\OAuthBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AddOAuthHelperPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig('uxgood_oauth');
        $helpers = $container->findTaggedServiceIds('uxgood_oauth.oauth_helper');
        foreach ($helpers as $id => $tags) {
            $aliasId = 'uxgood_oauth.oauth_helper.' .  $container->getDefinition($id)->getClass()::getName();
            if($container->hasAlias($aliasId)) {
                continue;
            }
            $container->setAlias($aliasId, new Alias($id));
        }


        foreach($config[0]['firewalls'] as $firewallName => $firewallConfig) {
            $managerId = 'uxgood_oauth.oauth.oauth_helper_manager';
            $manager = new ChildDefinition($managerId);
            foreach($firewallConfig['oauth_helpers'] as $helperAlias => $helperConfig) {
                if(!$container->hasAlias('uxgood_oauth.oauth_helper.' . $helperConfig['helper'])) {
                    throw new \RuntimeException('helper not found');
                }
                $helper = new ChildDefinition('uxgood_oauth.oauth_helper.' . $helperConfig['helper']);
                $helper->addArgument(new Reference('uxgood_oauth.http.client.default'));
                $helper->addArgument($helperConfig);
                $helper->addArgument(null);
                $helper->addArgument($helperAlias);
                $container->setDefinition('uxgood_oauth.oauth_helper.' . $firewallName . '.' . $helperAlias, $helper);
                $manager->addMethodCall('addOAuthHelper', array(new Reference('uxgood_oauth.oauth_helper.' . $firewallName . '.' . $helperAlias)));
            }
            $container->setDefinition($managerId . '.' . $firewallName, $manager);
        }
    }
}
