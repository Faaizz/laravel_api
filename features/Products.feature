Feature: Products
    Scenario: I want to get a paginated listing of all available products
        Given I use a valid API key
        And I am an anonymous user
        When I navigate to the products resource
        And I specify a section ""
        And I specify a sub-section ""
        And I specify a category ""
        And I make a GET request
        Then I get a 200 response
        And the response body has a -meta- field with a -total- property that has the number of matched items

    Scenario: I want to get a paginated listing of available female skirts 
        Given I use a valid API key
        And I am an anonymous user
        When I navigate to the products resource
        And I specify a section "clothing"
        And I specify a sub-section "female"
        And I specify a category "skirts"
        And I make a GET request
        Then I get a 200 response
        And the response body has a -meta- field with a -total- property that has the number of matched items
        And at least one "Product" is found

    Scenario: I want to search for available male trousers from a specific brand" 
        Given I use a valid API key
        And I am an anonymous user
        When I navigate to the products resource
        And initiate a search
        And I specify a search sub-section "male"
        And I specify a search brand "veritatis"
        And I make a POST request
        Then I get a 200 response
        And the response body has a -meta- field with a -total- property that has the number of matched items

