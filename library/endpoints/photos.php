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

class StileroFlickrPhotos extends StileroFlickrCurler{
    
    const API_URL = 'http://flickr.com/services/rest/';
    const METHOD_ADD_TAGS = 'flickr.photos.addTags';
    const METHOD_DELETE = 'flickr.photos.delete';
    const METHOD_GET_ALL_CONTEXTS = 'flickr.photos.getAllContexts';
    const METHOD_GET_EXIF = 'flickr.photos.getExif';
    const METHOD_GET_INFO = 'flickr.photos.getInfo';
    const METHOD_SET_TAGS = 'flickr.photos.setTags';
    const METHOD_GET_FAVOURITES = 'flickr.photos.getFavorites';
    
    public function __construct(\StileroFlickrApi $Api, $auth_token) {
        parent::__construct($Api, $auth_token);
    }
    
    /**
     * Add tags to a photo.
     * @param string $photo_id The id of the photo to add tags to.
     * @param string $tags The tags to add to the photo. Example (tag1 tag2 tag3)
     * @return string RAW JSON Response
     */
    public function addTags($photo_id, $tags){
        $params = array(
            'method' => self::METHOD_ADD_TAGS,
            'photo_id' => $photo_id,
            'tags' => $tags
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Add tags to a photo.
     * @param string $photo_id The id of the photo to add tags to.
     * @param string $tags The tags to add to the photo. Example (tag1 tag2 tag3)
     * @return string RAW JSON Response
     */
    public function setTags($photo_id, $tags){
        $params = array(
            'method' => self::METHOD_SET_TAGS,
            'photo_id' => $photo_id,
            'tags' => $tags
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Delete a photo from flickr.
     * @param string $photo_id The id of the photo to delete.
     * @return string RAW JSON Response
     */
    public function delete($photo_id){
        $params = array(
            'method' => self::METHOD_DELETE,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Returns all visible sets and pools the photo belongs to.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getAllContexts($photo_id){
        $params = array(
            'method' => self::METHOD_GET_ALL_CONTEXTS,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Retrieves a list of EXIF/TIFF/GPS tags for a given photo. The calling user must have permission to view the photo.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getExif($photo_id){
        $params = array(
            'method' => self::METHOD_GET_EXIF,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Get information about a photo. The calling user must have permission to view the photo.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getInfo($photo_id){
        $params = array(
            'method' => self::METHOD_GET_INFO,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Returns the list of people who have favorited a given photo.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getFavourites($photo_id){
        $params = array(
            'method' => self::METHOD_GET_FAVOURITES,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
}
