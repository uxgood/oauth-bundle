<?php

namespace UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper\OAuth2;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper\AbstractOAuthHelper;

class GenericOAuthHelper extends AbstractOAuthHelper
{
    public static function getName()
    {
        return 'oauth2';
    }
    public function getUserInformation($accessToken)
    {
        if ($this->options['use_bearer']) {
            $response = $this->httpClient->get(
                $this->buildUrl($this->options['profile_url']),
                array('Authorization' => 'Bearer '.$accessToken['access_token'])
            );
        } else {
            $response = $this->httpClient->get(
                $this->buildUrl($this->options['profile_url'], array($this->options['access_token_name'] => $accessToken['access_token']))
            );
        }
        return $this->getDecoder()->decode($response, $this->options['datamap']); 
    } 

    public function getAuthorizationUrl($redirectUri)
    {
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'state' => $this->generateNonce(),
            'redirect_uri' => $redirectUri
        );
        return $this->buildUrl($this->options['authorization_url'], $params);
    }

    public function getAccessToken(Request $request, $redirectUri)
    {
    
    }

    public function refreshAccessToken($refreshToken)
    {
    
    }

    public function revokeToken($token)
    {
    
    }

    public function handle(Request $request)
    {
        return $request->query->has('code');    
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefined('revoke_token_url');
    }
}
