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
        $this->request_path= $this->request_path . '/products';
    }

    /**
     * @When I specify a section :section
     */
    public function iSpecifyASection($section)
    {
        $this->request_path= $this->request_path . '/' . $section;
    }

    /**
     * @When I specify a sub-section :sub_section
     */
    public function iSpecifyASubSection($sub_section)
    {
        $this->request_path= $this->request_path . '/' . $sub_section;
    }

    /**
     * @When I specify a category :category
     */
    public function iSpecifyACategory($category)
    {
        $this->request_path= $this->request_path . '/' . $category;
    }



    /** S  E  A  R  C  H */
    /**
     * @When initiate a search
     */
    public function initiateASearch()
    {

        //Set search path
        $this->request_path .= '/search';

    }

    /**
     * @When I specify a search sub-section :sub_section
     */
    public function iSpecifyASearchSubSection($sub_section)
    {
        $this->request_body['sub_section']= $sub_section;
    }

    /**
     * @When I specify a search brand :brand
     */
    public function iSpecifyASearchBrand($brand)
    {        
        $this->request_body['brand']= $brand;

    }



}
