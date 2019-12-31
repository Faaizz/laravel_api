<?php

//namespace Behat\Context\GeneralContext;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use App\Staff;
 

/**
 * Defines application features from the specific context.
 */
class GeneralContext implements Context

{

    const VALID_API_KEY = "x6Q7KqJfghcRzgo1bCpKStslqsOhBR8VnQDe0NgAtAGOhnkWN6YCENhg21tO";

    protected $http_client;
    protected $api_key;
    protected $request_path;
    protected $request_body;
    protected $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {   
        //New GuzzleHttp Client
       $this->http_client= new \GuzzleHttp\Client([
                                                    'base_uri' => 'http://127.0.0.1:8000'
                                                ]);


        //INITIALIZE Request Path
        $this->request_path= '/api';

        //INITIALIZE Request Body
        $this->request_body= [];

    }

    /**
     * @Given I use a valid API key
     */
    public function iUseAValidApiKey()
    {
        $this->api_key= self::VALID_API_KEY;
    }

    /**
     * @Given I am an anonymous user
     */
    public function iAmAnAnonymousUser()
    {
        return true;
    }

    /**
     * @When I make a GET request
     */
    public function iMakeAGetRequest()
    {

        //Make GET request
        $this->response= $this->http_client->request(
                                                'GET',
                                                $this->request_path,
                                                [
                                                    'headers' => [
                                                        'Authorization' => 'Bearer ' . $this->api_key,
                                                        'Accept' => 'text/json'
                                                    ]
                                                ]
                                            );

    }


    /**
     * @When I make a POST request
     */
    public function iMakeAPostRequest()
    {
        echo $this->request_path;
        //Make GET request
        $this->response= $this->http_client->request(
                                                    'POST',
                                                    $this->request_path,
                                                    [
                                                        'headers' => [
                                                            'Authorization' => 'Bearer ' . $this->api_key,
                                                            'Accept' => 'text/json'
                                                        ],
                                                        'form_params' => $this->request_body
                                                    ]
                                                );

    }



     /* R  E  S  P  O  N  S  E */


    /**
     * @Then I get a :code response
     */
    public function iGetAResponse($code)
    {
        $response_code= $this->response->getStatusCode();
        //Check if response code doesn't match expected
        if( $response_code != $code ){

            return false;

        }
    }


    /**
     * @Then the response body has a -meta- field with a -total- property that has the number of matched items
     */
    public function theResponseBodyHasAMetaFieldWithANumberOfMatchedItems()
    {
        //Get resposne body
        $response_body= $this->response->getBody();

        //Convert JSON to assoc array
        $response_body= json_decode($response_body, true);

        //If meta property doesn't exists, return an error
        if( !$meta= $response_body['meta'] ){
            return false;
        }

        //If total property doesn't exist, return an error
        if( empty($meta['total']) ){
            return false;
        }

    }


    /**
     * @Then at least one :item is found
     */
    public function atLeastOneIsFound($item)
    {
        //Get response body
        $response_body= $this->response->getBody();

        //Convert JSON to assoc array
        $response_body= json_decode($response_body, true);

        //Get response meta
        $meta= $response_body['meta'];

        //If at least one item isn't found, return an error
        if( $meta['total'] < 1 ){
            return false;
        }
    }




}
