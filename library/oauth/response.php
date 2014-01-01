<?php
/**
 * Class for handling FB Responses
 *
 * @version  1.0
 * @package Stilero
 * @subpackage class-oauth-fb
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2013-dec-18 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrResponse{
    
    public $json;
    public $category;
    public $type;
    public $code;
    public $message;
    public $isError;
   
    private static function sanitize($response){
        $json = '';
        if(strpos($response, 'jsonFlickrApi') !== FALSE){
            $withoutStart = str_replace('jsonFlickrApi(', '', $response);
            $withoutEnd = str_replace(')', '', $withoutStart);
            $json = $withoutEnd;
        }
        return $json;
    }
    /**
     * Extracts information from FB responses
     * @param string $json
     */
    public static function handle($response) {
        $json = self::sanitize($response);
        $decoded = json_decode($json);
        if(isset($decoded->stat)){
            if($decoded->stat == 'fail'){
                self::error($decoded);
            }else{
                if(is_object($decoded)){
                    return $decoded;
                }
            }
        }else{
            return $json;
       }
    }
    
    /**
     * Handles error responses
     * @param stdClass $errorResponse
     */
    protected static function error($errorResponse){
        $code = null;
        $message = null;
        if (isset($errorResponse->message)){
            $message .= ': '.$errorResponse->message;
        }
        if (isset($errorResponse->code)){
            $code = $errorResponse->code;
        }
        JError::raiseError($code, $message);
    }
    
        
}
