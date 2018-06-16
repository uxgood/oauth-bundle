<?php
namespace UxGood\Bundle\OAuthBundle\Http;
use Psr\Http\Message\ResponseInterface;
use UxGood\Bundle\OAuthBundle\Http\Response;
use UxGood\Bundle\OAuthBundle\Http\MethodsClientInterface;

class SimpleMethodsClient implements MethodsClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $headers = [])
    {
        return $this->send('GET', $uri, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uri, array $headers = [])
    {
        return $this->send('HEAD', $uri, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($uri, array $headers = [])
    {
        return $this->send('TRACE', $uri, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $headers = [], $body = null)
    {
        return $this->send('POST', $uri, $headers, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $headers = [], $body = null)
    {
        return $this->send('PUT', $uri, $headers, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, array $headers = [], $body = null)
    {
        return $this->send('PATCH', $uri, $headers, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function options($uri, array $headers = [], $body = null)
    {
        return $this->send('OPTIONS', $uri, $headers, $body);
    }

    /**
     * {@inheritdoc}
     */
    public function send($method='GET', $uri, array $header = [], $body = null)
    {
        if($method == "POST" && !isset($header['Content-Type'])) {
            $header['Content-Type'] = 'application/x-www-form-urlencoded';
        }
        foreach ($header as $key => $value) {
            $header[$key] = "$key: $value";
        }
        $header = implode("\r\n", $header);
        if(is_array($body)) {
            $body = http_build_query($body);
        }
        $context = stream_context_create (
            array (
                'http'=>array (
                    'method'  => $method,
                    'header'  => $header,
                    'content' => $body,
                    'timeout' => 30,
                    //'proxy'   => '',
                    //'request_fulluri' => false,
                    'user_agent' => 'Mozilla/5.0',
                    'ignore_errors' => true,
                    //'protocol_version' => '1.0',
                    //'max_redirects' => 1,
                    //'follow_location' => 0
                )
            )
        );
        $responseData = file_get_contents($uri, false, $context);
        foreach($http_response_header as $key => $headerLine) {
            if(strpos($headerLine, 'HTTP/') === 0) {
                $offset = $key;
            }
        }
        $http_response_header = array_slice($http_response_header, $offset);
        $parts = explode(' ', array_shift($http_response_header), 3);
        $responseHeader = [];
        foreach($http_response_header as $headerLine) {
            @list($key, $value) = array_map('trim', explode(':', $headerLine));
            $responseHeader[$key] = array_merge($responseHeader[$key] ?? [], [$value]);
        }
        $response = new SimpleResponse($parts[1], $responseHeader, null, substr($parts[0], 5), $parts[2]);
        $response->getBody()->write($responseData);
        return $response;
    }
}
