<?php

namespace Highco\CurlBundle\Util;

class ResultAtom
{
    public
        $header = array(),
        $body = null;

    /**
     * return if http code is valid
     *
     * @access public
     * @return void
     */
    public function httpCodeIsValid()
    {
        $httpCode = isset($this->header['http_code']) ? (int) $this->header['http_code'] : 200;
        return !($httpCode >= 400 || $httpCode == 0);
    }
}
