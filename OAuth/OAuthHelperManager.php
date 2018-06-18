<?php
namespace UxGood\Bundle\OAuthBundle\OAuth;

use Symfony\Component\HttpFoundation\Request;
use UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper\OAuthHelperInterface;
use UxGood\Bundle\OAuthBundle\OAuth\OAuthHelperManagerInterface;

class OAuthHelperManager implements OAuthHelperManagerInterface
{
    protected $helpers = array();

    public function __construct()
    {

    }

    public function addOAuthHelper(OAuthHelperInterface $helper)
    {
        $name = $helper->getName();
        $this->helpers[$name] = $helper;
    }
    
    public function getOAuthHelperByName($name)
    {
    
    }

    public function getOAuthHelperByAlias($alias)
    {
    
    }
    
    public function getOAuthHelper(Request $request)
    {
    
    }

    public function getOAuthHelpers()
    {
        return $this->helpers;
    }
}
