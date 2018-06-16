<?php
namespace UxGood\Bundle\OAuthBundle\Http;
use Psr\Http\Message\StreamInterface;

class SimpleStream implements StreamInterface
{
    protected $stream;
    protected $size;

    /**
     * {@inheritdoc}
     */
    public function __construct($stream)
    {
        if (is_resource($stream) === false) {
            throw new \InvalidArgumentException('$stream argument must be a valid resource');
        }
        $this->stream = $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        if(!is_resource($this->stream))
        {
            return '';
        }
        try {
            $this->rewind();
            return $this->getContents();
        } catch (\RuntimeException $e) {
            return '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
        $this->detach();
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
        $stream = $this->stream;
        $this->stream = null;
        $this->size = null;
        return $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        if (!$this->size && is_resource($this->stream)) {
            $stats = fstat($this->stream);
            $this->size = $stats['size'];
        }
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
        if (!is_resource($this->stream) || ($position = ftell($this->stream)) === false ) {
            throw new \RuntimeException('could not tell the stream');
        }
        return $position;
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
        return is_resource($this->stream) ? feof($this->stream) : true;
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        // Note: fseek returns 0 on success!
        if (!$this->isSeekable() || fseek($this->stream, $offset, $whence) === -1) {
            throw new \RuntimeException('could not seek in the stream');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if (!$this->isSeekable() || rewind($this->stream) === false) {
            throw new \RuntimeException('could not rewind the stream');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
        if (!$this->isWritable() || ($written = fwrite($this->stream, $string)) === false) {
            throw new \RuntimeException('could not write to the stream');
        }
        // reset size so that it will be recalculated on next call to getSize()
        $this->size = null;
        return $written;
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        if (!$this->isReadable() || ($data = fread($this->stream, $length)) === false) {
            throw new \RuntimeException('could not read from the stream');
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        if (!$this->isReadable() || ($contents = stream_get_contents($this->stream)) === false) {
            throw new \RuntimeException('could not get contents of the stream');
        }
        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
        return null;
    }
}
