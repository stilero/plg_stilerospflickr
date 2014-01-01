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

class StileroFlickrPhotoscomments extends StileroFlickrCurler{
    
    const API_URL = 'http://flickr.com/services/rest/';
    const METHOD_ADD_COMMENTS = 'flickr.photos.comments.addComment';  
    const METHOD_EDIT_COMMENT = 'flickr.photos.comments.editComment';
    const METHOD_DELETE_COMMENT = 'flickr.photos.comments.deleteComment';
    const METHOD_GET_LIST = 'flickr.photos.comments.getList';
    
    public function __construct(\StileroFlickrApi $Api, $auth_token) {
        parent::__construct($Api, $auth_token);
    }
    /**
     * Returns the comments for a photo
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getList($photo_id){
        $params = array(
            'method' => self::METHOD_GET_LIST,
            'photo_id' => $photo_id,
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Add comment to a photo as the currently authenticated user.
     * @param string $photo_id The id of the photo
     * @param string $comment_text Text of the comment
     * @return string RAW JSON Response
     */
    public function addComments($photo_id, $comment_text){
        $params = array(
            'method' => self::METHOD_ADD_COMMENTS,
            'photo_id' => $photo_id,
            'comment_text' => $comment_text
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Edit the text of a comment as the currently authenticated user.
     * @param string $comment_id The id of the comment to edit
     * @param string $comment_text Text of the comment
     * @return string RAW JSON Response
     */
    public function editComment($comment_id, $comment_text){
        $params = array(
            'method' => self::METHOD_EDIT_COMMENT,
            'comment_id' => $comment_id,
            'comment_text' => $comment_text
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Delete a comment as the currently authenticated user.
     * @param string $comment_id The id of the comment
     * @return string RAW JSON Response
     */
    public function deleteComment($comment_id){
        $params = array(
            'method' => self::METHOD_DELETE_COMMENT,
            'comment_id' => $comment_id,
        );
        return $this->curlIt(self::API_URL, $params);
    }
}