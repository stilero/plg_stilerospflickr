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

class StileroFlickrApi{
    
    public $key;
    public $secret;
    
    /**
     * The Api is a container for the API key and secret
     * @param string $key Obtained from Flickr
     * @param string $secret Obtained from Flickr
     */
    public function __construct($key, $secret) {
        $this->key = $key;
        $this->secret = $secret;
    }
}
