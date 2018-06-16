<?php
namespace UxGood\Bundle\OAuthBundle\Http;
use Http\Client\Common\HttpMethodsClient as BaseHttpMethodsClient;
use UxGood\Bundle\OAuthBundle\Http\MethodsClientInterface;

/**
 * {@inheritdoc}
 */
class HttpMethodsClient extends BaseHttpMethodsClient implements MethodsClientInterface
{
}
