<?php

namespace UxGood\Bundle\OAuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UxGood\Bundle\OAuthBundle\DependencyInjection\UxGoodOAuthExtension;
use UxGood\Bundle\OAuthBundle\DependencyInjection\Security\Factory\OAuthFactory;
use UxGood\Bundle\OAuthBundle\DependencyInjection\Security\UserProvider\OAuthFactory as OAuthUserProviderFactory;

class UxGoodOAuthBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var $extension SecurityExtension */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new OAuthFactory());
        $extension->addUserProviderFactory(new OAuthUserProviderFactory());

    }
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        // return the right extension instead of "auto-registering" it. Now the
        // alias can be uxgood_oauth instead of ux_good_o_auth..
        if (null === $this->extension) {
            return new UxGoodOAuthExtension();
        }

        return $this->extension;
    }
}
