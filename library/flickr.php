<?php
/**
 * Flickr_API
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Flickr_API
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2013-dec-31 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickr{
    
    protected $Api;
    protected $Frob;
    protected $perms;
    public $People;
    public $Photos;
    public $Photoscomments;
    public $Photouploader;
    public $access_token;
    
    public function __construct($api_key, $api_secret, $perms='read') {
        $this->Api = new StileroFlickrApi($api_key, $api_secret);
        $this->Frob = new StileroFlickrFrob();
        $this->perms = $perms;
        return $this;
    }
    /**
     * Initializes all endpoints
     */
    private function _endpoints(){
        $this->People = new StileroFlickrPeople($this->Api, $this->access_token);
        $this->Photos = new StileroFlickrPhotos($this->Api, $this->access_token);
        $this->Photoscomments = new StileroFlickrPhotoscomments($this->Api, $this->access_token);
        $this->Photouploader = new StileroFlickrPhotouploader($this->Api, $this->access_token);
        return $this;
    }
    /**
     * Initializes the API
     * If a token is not set then you will be redirected to the auth page
     */
    public function init(){
        if( !isset($this->access_token) && !StileroFlickrFrob::hasFrobInGetRequest() ){
            $Url = new StileroFlickrUrl($this->Api);
            $Url->redirectToUrl($this->perms);
        }else if( StileroFlickrFrob::hasFrobInGetRequest() ){
            $this->Frob->fetchFrob();
            $Authtoken = new StileroFlickrAuthtoken($this->Api, $this->Frob);
            $Authtoken->getToken();
            $this->access_token = $Authtoken->token;
        }if(isset($this->access_token)){
            $this->_endpoints();
        }
        return $this;
    }
    
    public function setAccessToken($token){
        $this->access_token = $token;
    }
}
