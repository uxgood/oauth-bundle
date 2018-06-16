<?php
namespace UxGood\Bundle\OAuthBundle\Http;

interface MethodsClientInterface
{
    /**
     * Sends a GET request.
     *
     * @param string|UriInterface $uri
     * @param array               $headers
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function get($uri, array $headers = []);
    /**
     * Sends a HEAD request.
     *
     * @param string|UriInterface $uri
     * @param array               $headers
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function head($uri, array $headers = []);
    /**
     * Sends a TRACE request.
     *
     * @param string|UriInterface $uri
     * @param array               $headers
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function trace($uri, array $headers = []);
    /**
     * Sends a POST request.
     *
     * @param string|UriInterface         $uri
     * @param array                       $headers
     * @param string|StreamInterface|null $body
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function post($uri, array $headers = [], $body = null);
    /**
     * Sends a PUT request.
     *
     * @param string|UriInterface         $uri
     * @param array                       $headers
     * @param string|StreamInterface|null $body
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function put($uri, array $headers = [], $body = null);
    /**
     * Sends a PATCH request.
     *
     * @param string|UriInterface         $uri
     * @param array                       $headers
     * @param string|StreamInterface|null $body
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function patch($uri, array $headers = [], $body = null);
    /**
     * Sends a OPTIONS request.
     *
     * @param string|UriInterface         $uri
     * @param array                       $headers
     * @param string|StreamInterface|null $body
     *
     * @throws Exception
     *
     * @return string|ResponseInterface
     */
    public function options($uri, array $headers = [], $body = null);
}
