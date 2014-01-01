<?php
/**
 * Curler Class for sending requests
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Flickr_API
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2014-jan-01 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrCurler{
    /**
     * The posts params to send to the API
     * @var array 
     */
    protected $params;
    /**
     * The API Class that holds the api_key and api_secret
     * @var StileroFlickrApi 
     */
    protected $Api;
    /**
     * The curl handler
     * @var object 
     */
    protected $curl;
    /**
     * The auth token
     * @var string 
     */
    protected $auth_token;
    const CURL_REQUEST_TYPE_POST = 'POST';
    const CURL_REQUEST_TYPE_GET = 'GET';
    
    /**
     * Class for handling the sending and receiveing of requests to the API
     * @param StileroFlickrApi $Api
     * @param string $auth_token The auth token
     */
    public function __construct(StileroFlickrApi $Api, $auth_token) {
        $this->Api = $Api;
        $this->auth_token = $auth_token;
    }
    /**
     * Sets the response format to JSON
     */
    private function format(){
        $this->params['format'] = 'json';
    }
    /**
     * Adds the auth parts to the params
     */
    private function authParams(){
        $this->params['api_key'] = $this->Api->key;
        $this->params['auth_token'] = $this->auth_token;
    }
    /**
     * Adds a signature to the request
     */
    private function signature(){
        $this->params['api_sig'] = StileroFlickrSignature::getSignature($this->params, $this->Api);
    }
    /**
     * Sets the request type parameters to the curler
     * @param string $type The Request type. Use the constants of this class. Example (GET, POST)
     */
    private function requestType($type){
        if($type == self::CURL_REQUEST_TYPE_POST){
            curl_setopt($this->curl, CURLOPT_POST,1);
        }else if($type == self::CURL_REQUEST_TYPE_GET){
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
        }
    }
    /**
     * Initializes the curler
     * @param boolean $useAuth Set to true for an authorized request
     */
    private function init($useAuth){
        if($useAuth){
            $this->authParams();
        }
        $this->format();
        $this->signature();
    }
    
    /**
     * Sends the request to the API and returns the raw response
     * @param string $url URL to send the request to
     * @param array $params Post params to send
     * @param boolean $useAuth Set true for an authenticated request
     * @param string $type The request type. Use the constants of this class. Example (POST,GET)
     * @return string The raw response
     */
    protected function curlIt($url, array $params, $useAuth=true, $type='POST'){
        $this->params = $params;
        $this->init($useAuth, $type);
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL,$url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $this->requestType($type);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->params);
        $response=curl_exec($this->curl);
        curl_close ($this->curl);
        return $response;
    }
}