<?php

namespace Highco\CurlBundle\Adapter;

use Highco\CurlBundle\Util\Curl as CurlCaller;

/**
 * DefaultCurl
 *
 * @uses ICurl
 * @package
 * @version $id$
 * @author Stephane PY <s.py@groupe-highco.com>
 * @author Nikola Petkanski <nikola@petkanski.com>
 */
class DefaultCurl extends AbstractCurl implements ICurl
{
    protected static $default_opts = array(
        CURLOPT_HEADER          => 1,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_TIMEOUT         => 30,
        CURLOPT_CONNECTTIMEOUT  => 5,
        CURLOPT_FORBID_REUSE    => true,
        CURLOPT_FRESH_CONNECT   => true,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_MAXREDIRS       => 5,
        CURLOPT_ENCODING        => '',
        CURLOPT_USERAGENT       => 'Highco\CurlBundle',
    );

    public function call($url, $method, $parameters = array(), $curl_options = array())
    {
        $opts   = $curl_options + self::$default_opts;

        switch($method)
        {
            case self::REQUEST_GET:

                $opts[CURLOPT_CUSTOMREQUEST] = "GET";

                if(false === empty($parameters))
                {
                    $url .= "?".trim(http_build_query($parameters));
                }

                break;

            case self::REQUEST_POST:

                $opts[CURLOPT_POST]       = 1;
                $opts[CURLOPT_POSTFIELDS] = http_build_query($parameters);

                break;

            case self::REQUEST_DELETE:

                $opts[CURLOPT_CUSTOMREQUEST] = "DELETE";
                $opts[CURLOPT_POSTFIELDS]    = http_build_query($parameters);

                break;

            case self::REQUEST_PUT:

                $opts[CURLOPT_CUSTOMREQUEST] = "PUT";
                //$opts[CURLOPT_HTTPHEADER] = array('X-HTTP-Method-Override: PUT');
                $opts[CURLOPT_POSTFIELDS] = http_build_query($parameters);

                break;

            default:
                throw new \InvalidArgumentException('The method '.$method.' is not yet implemented on '.__CLASS__);
                break;

        }

        $caller = new CurlCaller($url, $opts);
        return $caller->exec();
    }
}
