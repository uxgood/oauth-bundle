<?php

namespace UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Psr\Http\Message\ResponseInterface;
use UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper\OAuthHelperInterface;
use UxGood\Bundle\OAuthBundle\Http\MethodsClientInterface;

abstract class AbstractOAuthHelper implements OAuthHelperInterface
{
    protected $options = [];
    protected $httpClient;
    protected $state;
    protected $alias;
    protected $csrfTokenManager;

    public function __construct(MethodsClientInterface $httpClient, array $options,
        CsrfTokenManagerInterface $csrfTokenManager = null, $alias = null)
    {
        $this->httpClient = $httpClient;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->alias = $alias;

        unset($options['key_maps']);
        unset($options['helper']);
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    //abstract public static function getName();

    public function getOption($name)
    {
        if(array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException('Unknown option ' . $name);
        }
        return $this->options[$name];
    }

    //abstract public function getAccessToken(Request $request, $redirectUri);

    public function refreshAccessToken($refreshToken)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    } 

    public function revokeToken($token)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'client_id',
            'client_secret',
            'authorization_url',
            'access_token_url',
            'user_info_url',
        ]); 
    
        $resolver->setDefaults([
            'scope' => null,
            'csrf' => false,
        ]); 

        $resolver->setDefined('use_comma'); 
        $resolver->setDefined('decoder'); 
        $resolver->setDefined('base_url'); 
        $resolver->setAllowedValues('csrf', [true, false]);
    }

    protected function generateNonce()
    {
        if ($this->csrfTokenManager) {
            return $this->csrfTokenManager->getToken('oauth.' . $this->getAlias());
        }
        return 'oauth.' . $this->getAlias();
    }

    protected function getAlias()
    {
        return $this->alias;
    }

    protected function buildUrl($url, $params)
    {
        if(empty($params)) {
            return $url;
        }
        return $url . (false !== strpos($url, '?') ? '&' : '?') . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }

    public function getDecoder()
    {
        return new $this->options['decoder'];
    }
}
