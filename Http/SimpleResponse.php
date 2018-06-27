<?php
namespace UxGood\Bundle\OAuthBundle\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\HeadersInterface;
use Symfony\Component\HttpFoundation\Response;

class SimpleResponse implements ResponseInterface
{
    protected $protocolVersion = '1.1';
    protected $statusCode = 200;
    protected $reasonPhrase = '';
    protected $body;
    protected $headers;

    /**
     * {@inheritdoc}
     */
    public function __construct($status = 200, array $headers = null, StreamInterface $body = null, $version = '1.1', $reason = '')
    {
        $this->statusCode = $status;
        $this->headers = $headers ? $headers : [];
        $this->body = $body ? $body : new SimpleStream(fopen('php://temp', 'r+'));
        $this->protocolVersion = $version;
        if($reason !== '') {
            $this->reasonPhrase = $reason;
        } elseif (isset(Response::statusTexts[$this->statusCode])) {
            $this->reasonPhrase = Response::statusTexts[$this->statusCode];
        } else {
            $this->reasonPhrase = 'Unknown';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        return $this->headers[$name] ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
        return implode(',', $this->getHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        throw new \RuntimeException(__METHOD__ . ': method not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }
}
