<?php

namespace Highco\CurlBundle\Util;

/**
 * Curl
 *
 * @package
 * @version $id$
 * @author Stephane PY <s.py@groupe-highco.com>
 */
class Curl
{
    protected
        $uri = null,
        $ch = null,
        $options = array();

    public function __construct($uri = null, $options = array())
    {
        $this->ch = curl_init($uri);
        $this->setOptions($options);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    public function getHandle()
    {
        return $this->ch;
    }

    public function setOptions($options = array())
    {
        if (!empty($options))
        {
            curl_setopt_array(
                $this->ch,
                array_diff_key($options, array(CURLOPT_HEADER => 1))
            );
            $this->options = $options;
        }
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function exec()
    {
        $r = new ResultAtom();
        $r->body = curl_exec($this->ch);
        if(isset($this->options[CURLOPT_HEADER]) && $this->options[CURLOPT_HEADER])
        {
            $r->header = curl_getinfo($this->ch);
        }

        return $r;
    }
}
