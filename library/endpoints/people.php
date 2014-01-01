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

class StileroFlickrPeople extends StileroFlickrCurler{
    
    const API_URL = 'http://flickr.com/services/rest/';
    const METHOD_GET_INFO = 'flickr.people.getInfo';
    const METHOD_FIND_BY_USERNAME = 'flickr.people.findByUsername';
    const METHOD_FIND_BY_EMAIL = 'flickr.people.findByEmail';
    const METHOD_GET_GROUPS = 'flickr.people.getGroups';
    const METHOD_GET_PHOTOS = 'flickr.people.getPhotos';
    const METHOD_GET_PHOTOS_OF = 'flickr.people.getPhotosOf';
    
    public function __construct(\StileroFlickrApi $Api, $auth_token) {
        parent::__construct($Api, $auth_token);
    }
    
    /**
     * Get information about a user.
     * @param string $user_id The NSID of the user to fetch information about.
     * @return string RAW JSON response
     */
    public function getInfoFromId($user_id){
        $params = array(
            'method' => self::METHOD_GET_INFO,
            'user_id' => $user_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Return a user's NSID, given their username.
     * @param string $username
     * @return string Raw JSON Response
     */
    public function findByUsername($username){
        $params = array(
            'method' => self::METHOD_FIND_BY_USERNAME,
            'username' => $username
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Return a user's NSID, given their email address
     * @param string $email The email address of the user to find (may be primary or secondary).
     * @return string Raw JSON Response
     */
    public function findByEmail($email){
        $params = array(
            'method' => self::METHOD_FIND_BY_EMAIL,
            'find_email' => $email
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Returns the list of groups a user is a member of.
     * @param string $user_id The NSID of the user to fetch groups for.
     * @return string Raw JSON Response
     */
    public function getGroups($user_id){
        $params = array(
            'method' => self::METHOD_GET_GROUPS,
            'user_id' => $user_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Return photos from the given user's photostream. Only photos visible to the calling user will be returned.
     * @param string $user_id The NSID of the user to fetch groups for.
     * @return string Raw JSON Response
     */
    public function getPhotos($user_id){
        $params = array(
            'method' => self::METHOD_GET_PHOTOS,
            'user_id' => $user_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Return photos from the given user's photostream. Only photos visible to the calling user will be returned.
     * @param string $user_id The NSID of the user to fetch groups for.
     * @return string Raw JSON Response
     */
    public function getPhotosOf($user_id){
        $params = array(
            'method' => self::METHOD_GET_PHOTOS_OF,
            'user_id' => $user_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
}
