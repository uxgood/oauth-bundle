<?php

namespace UxGood\Bundle\OAuthBundle\Security\Http\Firewall;

use UxGood\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class OAuthListener extends AbstractAuthenticationListener
{
    /**
     * {@inheritdoc}
     */
    public function requiresAuthentication(Request $request)
    {
        return parent::requiresAuthentication($request);
    }

    /**
     * {@inheritdoc}
     */
    protected function attemptAuthentication(Request $request)
    {
        $token = new OAuthToken('');
        return $this->authenticationManager->authenticate($token);
    }
}
