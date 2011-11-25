Feature: Curl GET
  I want to use GET http request to call page

  Scenario: HEADER on google
    Given I use adapter "Highco\Bundle\CurlBundle\Adapter\DefaultCurl"
    And I call url "http://www.google.fr"
    And I use "GET" http request
    When I execute curl action
    Then I should have header "http_code" assert to "200"
    Then I should have header "content_type" assert to "text/html; charset=ISO-8859-1"
    And I call url "http://google.fr"
    When I execute curl action
    Then I should have header "http_code" assert to "301"
