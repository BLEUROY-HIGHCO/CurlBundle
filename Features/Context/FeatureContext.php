<?php

namespace Highco\Bundle\CurlBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Highco\Bundle\CurlBundle\Util\ResultAtom;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
{
    protected $adapter;
    protected $adapter_class;
    protected $curl_options = array();
    protected $output;
    protected $parameters   = array();
    protected $request_method;
    protected $uri;

    /**
     * @Given /^I use adapter "([^"]*)"$/
     */
    public function iUseAdapter($adapter_class)
    {
        $this->adapter_class = $adapter_class;
        $this->adapter = new $adapter_class();
    }

    /**
     * @Given /^I have these parameters:$/
     */
    public function iHaveTheseParameters(TableNode $table)
    {
        $hash = $table->getHash();
        $this->parameters = array_pop($hash);
    }

    /**
     * @Given /^I call url "([^"]*)"$/
     */
    public function iCallUrl($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @Given /^I use "([^"]*)" http request$/
     */
    public function iUseHttpRequest($method)
    {
        $this->request_method = $method;
    }

    /**
     * @Given /^I have these curl options:$/
     */
    public function iHaveTheseCurlOptions(TableNode $table)
    {
        $hash = $table->getHash();
        $this->curl_options = array_pop($hash);
    }

    /**
     * @When /^I execute curl action$/
     */
    public function iExecuteCurlAction()
    {
        $this->output = $this->adapter->call($this->uri, $this->request_method, $this->parameters, $this->curl_options);
    }

    /**
     * @Then /^I should have header "([^"]*)" assert to "([^"]*)"$/
     */
    public function iShouldHaveHeaderAssertTo($header_key, $value)
    {
        assertEquals($this->output->header[$header_key], $value);
    }
}
