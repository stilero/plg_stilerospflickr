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

class StileroFlickrContacts extends StileroFlickrCurler{
    
    const API_URL = 'http://flickr.com/services/rest/';
    const METHOD_GET_LIST = 'flickr.contacts.getList';
    
    public function __construct(\StileroFlickrApi $Api, $auth_token) {
        parent::__construct($Api, $auth_token);
    }
    
    /**
     * Get information about a user.
     * @param string $user_id The NSID of the user to fetch information about.
     * @return string RAW JSON response
     */
    public function getList(){
        $params = array(
            'method' => self::METHOD_GET_LIST
        );
        return $this->curlIt(self::API_URL, $params);
    }
    
}
