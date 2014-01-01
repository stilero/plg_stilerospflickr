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
    const SANITIZE_STRING = '/[^A-Z0-9_\.-]/i';
    const SANITIZE_INT = '/[^A-Z0-9_\.-]/i';
    const SANITIZE_URL = '/[^A-Z0-9_\.-]/i';
    
    /**
     * Sanitizes a string
     * @param string $string String to sanitize
     * @param string $type Preg pattern to use
     * @param string $filter filter type to use
     * @return string Filtered and sanitized string
     */
    protected static function sanitize($string, $type, $filter){
        $cleaned = (string) preg_replace($type, '', $string);
        $trimmed = ltrim($cleaned, '.');
        $filtered = filter_var($trimmed, $filter);
        return $filtered;
    }
    /**
     * Cleans strings and strips out unwanted characters
     * @param string $string
     * @return string cleaned string
     */
    public static function sanitizeString($string){
        return self::sanitize($string, self::SANITIZE_STRING, FILTER_SANITIZE_STRING);
    }
    
    /**
     * Cleans ints and strips out unwanted characters
     * @param string $string
     * @return string cleaned string
     */
    public static function sanitizeInt($string){
        return self::sanitize($string, self::SANITIZE_INT, FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     * Cleans urls and strips out unwanted characters
     * @param string $string
     * @return string cleaned string
     */
    public static function sanitizeUrl($string){
        return self::sanitize($string, self::SANITIZE_URL, FILTER_SANITIZE_URL);
    }
    
    /**
     * Fetches the oauth code from a get request
     */
    public function fetchFrob(){
        if(isset($_GET['frob'])){
            $sanitizedFrob = self::sanitizeString($_GET['frob']);
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
        $this->frob = self::sanitizeString($frob);
    }
}
