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

class StileroFlickrSignature{
    
    /**
     * Builds and returns a signature string
     * @param array $params
     * @param StileroFlickrApi $Api
     * @return string MD5 Hexadecimal
     */
    public static function getSignature(array $params, StileroFlickrApi $Api){
        uksort($params, 'strcmp');
        $str = $Api->secret;
        foreach ($params as $key => $value) {
            $str .= $key.$value;
        }
        $md5 = md5($str);
        return $md5;
    }
}
