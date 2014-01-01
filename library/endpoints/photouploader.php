<?php
/**
 * Photo Class for uploading and replacing photos
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Flickr_API
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2014-jan-01 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrPhotouploader{
    
    protected $Api;
    protected $auth_token;
    
    const API_URL_UPLOAD = 'http://up.flickr.com/services/upload/';
    const API_URL_REPLACE = 'http://api.flickr.com/services/replace/';
    const SAFETY_LEVEL_SAFE = 1;
    const SAFETY_LEVEL_MODERATE = 2;
    const SAFETY_LEVEL_RESTRICTED = 3;
    const CONTENT_TYPE_PHOTO = 1;
    const CONTENT_TYPE_SCREENSHOT = 2;
    const CONTENT_TYPE_OTHER = 3;
    const HIDDEN_SHOW_IN_SEARCHES = 1;
    const HIDDEN_HIDE_IN_SEARCHES = 2;
    
    
    public function __construct(StileroFlickrApi $Api, $auth_token) {
        $this->Api = $Api;
        $this->auth_token = $auth_token;
    }
    
    protected function curlIt($url, $params){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response=curl_exec ($ch);
        curl_close ($ch);
        return $response;
    }
    
    /**
     * Upload a photo to Flickr
     * @param string $file The full path to the The file to upload.
     * @param string $title The title of the photo.
     * @param string $description A description of the photo. May contain some limited HTML.
     * @param string $tags A space-seperated list of tags to apply to the photo.
     * @param integer $is_public Set to 0 for no, 1 for yes. Specifies who can view the photo. Use constants of this class.
     * @param integer $is_friend Set to 0 for no, 1 for yes. Specifies who can view the photo. Use constants of this class.
     * @param integer $is_family Set to 0 for no, 1 for yes. Specifies who can view the photo. Use constants of this class.
     * @param integer $safety_level Set to 1 for Safe, 2 for Moderate, or 3 for Restricted. Use constants of this class.
     * @param integer $content_type Set to 1 for Photo, 2 for Screenshot, or 3 for Other. Use constants of this class.
     * @param integer $hidden Set to 1 to keep the photo in global search results, 2 to hide from public searches. Use constants of this class.
     * @return string raw response
     */
    public function upload($file, $title='', $description='', $tags='', $is_public=1, $is_friend=1, $is_family=1, $safety_level=1, $content_type=1, $hidden=1){
        $params = array(
            'title' => $title,
            'description' => $description,
            'tags' => $tags,
            'is_public' => $is_public,
            'is_friend' => $is_friend,
            'is_family' => $is_family,
            'safety_level' => $safety_level,
            'content_type' => $content_type,
            'hidden' => $hidden,
            'api_key' => $this->Api->key,
            'auth_token' => $this->auth_token
        );
        $signature = StileroFlickrSignature::getSignature($params, $this->Api);
        $params['api_sig'] = $signature;
        $file_name_with_full_path = realpath($file);
        $params['photo'] = '@'.$file_name_with_full_path;
        $response = $this->curlIt(self::API_URL_UPLOAD, $params);
        return $response;
    }
    
    /**
     * Replaces a photo with the photo attached
     * @param string $file The full path to the The file to upload.
     * @param string $photo_id The ID of the photo to replace.
     * @return string raw response
     */
    public function replace($file, $photo_id){
        $params = array(
            'photo_id' => $photo_id,
            'api_key' => $this->Api->key,
            'auth_token' => $this->auth_token
        );
        $signature = StileroFlickrSignature::getSignature($params, $this->Api);
        $params['api_sig'] = $signature;
        $file_name_with_full_path = realpath($file);
        $params['photo'] = '@'.$file_name_with_full_path;
        $response = $this->curlIt(self::API_URL_REPLACE, $params);
        return $response;
    }
}
