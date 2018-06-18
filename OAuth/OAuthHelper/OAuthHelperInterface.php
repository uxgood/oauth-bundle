<?php

namespace UxGood\Bundle\OAuthBundle\OAuth\OAuthHelper;
use Symfony\Component\HttpFoundation\Request;


interface OAuthHelperInterface
{
    public function getUserInformation($accessToken);
    public function getAuthorizationUrl($redirectUri);
    public function getAccessToken(Request $request, $redirectUri);
    public static function getName();
    public function getOption($name);
    public function refreshAccessToken($refreshToken);
    public function revokeToken($token);
    public function handle(Request $request);
}
