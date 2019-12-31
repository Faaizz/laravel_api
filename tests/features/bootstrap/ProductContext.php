<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class ProductContext extends GeneralContext

{

    //INHERITED FROM GeneralContext
    //protected $http_client;
    //protected $request_path= "";
    //protected $response;
    
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
       parent::__construct();
    }



    /**
     * @When I navigate to the products resource
     */
    public function iNavigateToTheProductsResource()
    {
        //Add Product path to $request_path
        $this->request_path= $this->request_path."products";
    }

    /**
     * @When I specify a section :arg1
     */
    public function iSpecifyASection2($arg1)
    {
        //Add specified section path to $request_path
        $this->request_path= $this->request_path."/".$arg1;
    }

    /**
     * @When I specify a sub-section :arg1
     */
    public function iSpecifyASubSection2($arg1)
    {
        //Add specified sub-section path to $request_path
        $this->request_path= $this->request_path."/".$arg1;
    }

    /**
     * @When I specify a category :arg1
     */
    public function iSpecifyACategory2($arg1)
    {
       //Add specified category path to $request_path
       $this->request_path= $this->request_path."/".$arg1;
    }

    /**
     * @When I make a request
     */
    public function iMakeARequest()
    {
        //Make request
        $this->response= $this->http_client->request('GET', $this->request_path);
    }
    
    /**
     * @Then the response body has a -meta- field with a number of all products matching the specified criteria in the total field
     */
    public function theResponseBodyHasAMetaFieldWithANumberOfAllProductsMatchingTheSpecifiedCriteriaInTheTotalField()
    {
        
        throw new Exception($this->$request_path);
    }
}
