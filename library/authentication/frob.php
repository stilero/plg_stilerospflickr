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

class StileroFlickrFrob{
    
    public $frob;
    
    /**
     * Fetches the oauth code from a get request
     */
    public function fetchFrob(){
        if(isset($_GET['frob'])){
            $sanitizedFrob = StileroFlickrSanitizer::sanitizeString($_GET['frob']);
            $this->frob = $sanitizedFrob;
        }
    }
    
    /**
     * Checks if a code variable is found in the received GET-request
     * @return boolean true if found
     */
    public static function hasFrobInGetRequest(){
        if(isset($_GET['frob'])){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Sets code to the class
     * @param string $frob
     */
    public function setFrob($frob){
        $this->frob = StileroFlickrSanitizer::sanitizeString($frob);
    }
}
