HighcoCurlBundle
==================

This bundle uses the php curl library.

Requirements:
- php built with curl support

# Simple example:

````php
<?php
use Highco\CurlBundle\Adapter\DefaultCurl;

$curl = new DefaultCurl;

$result = $curl->call('https://my.site.com/api.php', DefaultCurl::REQUEST_GET, array('call' => 'someCall'));
/* @var $result Highco\CurlBundle\Util\ResultAtom */
`````


# Example using mutual authentication over SSLv3:

````php
<?php
use Highco\CurlBundle\Adapter\DefaultCurl;

$curlOptions = array(
    CURLOPT_SSLCERT         => '/path/to/ssl/cert',
    CURLOPT_SSLKEY          => '/path/to/ssl/key',
    CURLOPT_CAINFO          => '/path/to/ssl/ca',
    CURLOPT_SSL_VERIFYPEER  => 1,
    CURLOPT_SSL_VERIFYHOST  => 2,
    CURLOPT_SSLVERSION      => 3,
);

$curl = new DefaultCurl;

$result = $curl->call('https://my.site.com/api.php', DefaultCurl::REQUEST_GET, array('call' => 'someCall'), $curlOptions);
/* @var $result Highco\CurlBundle\Util\ResultAtom */
`````
