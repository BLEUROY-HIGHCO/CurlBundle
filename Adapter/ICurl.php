<?php

namespace Highco\CurlBundle\Adapter;

interface ICurl
{
    public function call($url, $method, $parameters = array(), $curl_options = array());
}
