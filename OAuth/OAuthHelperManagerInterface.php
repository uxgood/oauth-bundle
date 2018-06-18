<?php
namespace UxGood\Bundle\OAuthBundle\OAuth;

use Symfony\Component\HttpFoundation\Request;
use UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper\OAuthHelperInterface;

interface OAuthHelperManagerInterface
{
    public function addOAuthHelper(OAuthHelperInterface $helper);
    public function getOAuthHelperByName($name);
    public function getOAuthHelperByAlias($alias);
    public function getOAuthHelper(Request $request);
}
