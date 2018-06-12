<?php

namespace UxGood\Bundle\OAuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use UxGood\Bundle\OAuthBundle\DependencyInjection\UxGoodOAuthExtension;

class UxGoodOAuthBundle extends Bundle
{
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
