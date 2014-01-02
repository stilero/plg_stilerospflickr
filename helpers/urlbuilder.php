<?php
/**
 * Url builder
 *
 * @version  1.0
 * @package Stilero
 * @subpackage plg_stilerospflickr
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2014-jan-02 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
define('_JEXEC', 1); 
// no direct access
defined('_JEXEC') or die('Restricted access'); 

if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
define('PATH_FLICKR_LIBRARY_AUTH', '..'.DS.'library'.DS.'authentication'.DS);
define('PATH_FLICKR_LIBRARY_OAUTH', '..'.DS.'library'.DS.'oauth'.DS);
define('PATH_FLICKR_LIBRARY_HELPERS', '..'.DS.'library'.DS.'helpers'.DS);
require_once PATH_FLICKR_LIBRARY_AUTH.'url.php';
require_once PATH_FLICKR_LIBRARY_AUTH.'permissions.php';
require_once PATH_FLICKR_LIBRARY_OAUTH.'api.php';
require_once PATH_FLICKR_LIBRARY_OAUTH.'signature.php';
require_once PATH_FLICKR_LIBRARY_HELPERS.'sanitizer.php';

class UrlBuilder{
    protected $api_key;
    protected $api_secret;
    public $url;
    
    /**
     * Processes the params from the post
     * @return \UrlBuilder
     */
    protected function processPost(){
        $this->api_key = StileroFlickrSanitizer::sanitizeString($_GET['api_key']);
        $this->api_secret = StileroFlickrSanitizer::sanitizeString($_GET['api_secret']);
    }
    /**
     * Returns and prints the URL
     * @return string The url
     */
    public function getUrl(){
        $this->processPost();
        $Api = new StileroFlickrApi($this->api_key, $this->api_secret);
        $Url = new StileroFlickrUrl($Api);
        return $Url->getUrl(StileroFlickrPermissions::WRITE);
    }
}

class Json{
    protected $object;
    public $json;
    
    public function __construct($response) {
        $object = new stdClass();
        $object->url = $response;
        $this->json = json_encode($object);
        return $this;
    }
    /**
     * Prints the JSON
     */
    public function output(){
        print $this->json;
    }
}
$URL = new UrlBuilder();
$url = $URL->getUrl();
$JSON = new Json($url);
$JSON->output();
