<?php

namespace Highco\Bundle\CurlBundle\Util;

class CurlMulti
{
    protected
        $mh      = null,
        $curls   = array(),
        $results = array(),
        $options = array();

    public function __construct($options = array())
    {
        $this->mh = curl_multi_init();
        $this->setOptions($options);
    }

    public function __destruct()
    {
        curl_multi_close($this->mh);
    }

    public function add($uris=array(), $options = null)
    {
        $o     = empty($options) ? $this->options : $options;
        $_uris = array_values((array)$uris);

        foreach($_uris as $uri)
        {
            if (!isset($this->curls[$uri]))
            {
                $this->curls[$uri] = array();
            }

            $i = array_push($this->curls[$uri], new brCurl($uri, $o));
            curl_multi_add_handle($this->mh, $this->curls[$uri][$i-1]->getHandle());
        }
    }

    public function setOptions($options = array())
    {
        if (!empty($options))
        {
            $this->options = $options;
        }
    }

    public function exec_async()
    {
        static $running = null;
        curl_multi_exec($this->mh, $running);

        return $running;
    }

    public function exec()
    {
        $running = null;
        do
        {
            curl_multi_exec($this->mh, $running);
        }
        while($running > 0);

        return $this;
    }

    public function fetch()
    {
        foreach($this->curls as $uri => $curls)
        {
            foreach($curls as $k => $curl)
            {
                $r       = new ResultAtom();
                $r->body = curl_multi_getcontent($curl->getHandle());
                $o       = $curl->getOptions();

                if(isset($o[CURLOPT_HEADER]) && $o[CURLOPT_HEADER])
                {
                    $r->header = curl_getinfo($curl->getHandle());
                }

                curl_multi_remove_handle($this->mh, $curl->getHandle());
                $this->results[$uri][$k] = $r;
                unset($r);
            }
        }

        return $this->results;
    }
}
