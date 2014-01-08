<?php
/**
 * Stilero Social Promoter Flickr Plugin
 *
 * @version  1.0
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2013-dec-26 Stilero Webdesign (http://www.stilero.com)
 * @category Plugins
 * @license	GPLv2
 */

// no direct access
defined('_JEXEC') or die ('Restricted access');
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

define('PATH_FLICKR_LIBRARY', dirname(__FILE__).DS.'library'.DS);
JLoader::discover('StileroFlickr', PATH_FLICKR_LIBRARY, false, true);
JLoader::register('StileroFlickr', PATH_FLICKR_LIBRARY.DS.'flickr.php');
JLoader::register('SocialpromoterImporter', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_socialpromoter'.DS.'helpers'.DS.'importer.php');
JLoader::register('SocialpromoterPosttype', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_socialpromoter'.DS.'library'.DS.'posttype.php');
jimport('joomla.event.plugin');

class plgSocialpromoterStilerospflickr extends JPlugin {
    protected $Flickr;
    protected $api_key;
    protected $api_secret;
    protected $auth_token;
    protected $_desc_suffix;
    
    const SP_NAME = 'Flickr Plugin';
    const SP_DESCRIPTION = 'Posts photos to Flickr';
    const SP_IMAGE = '';
    protected $supportedPosttypes;
    
    public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);
        $language = JFactory::getLanguage();
        $language->load('plg_socialpromoter_stilerospflickr', JPATH_ADMINISTRATOR, 'en-GB', true);
        $language->load('plg_socialpromoter_stilerospflickr', JPATH_ADMINISTRATOR, null, true);
        $this->_setParams();
    }
        
    /**
     * Reads the params and sets them in the class if they are not properly loaded
     * by default
     */
    private function _setParams(){
        if(!isset($this->params)){
            $plg = JPluginHelper::getPlugin('socialpromoter', 'stilerospflickr');
            $plg_params = new JRegistry();
            $plg_params->loadString($plg->params);
            $this->params = $plg_params;
        }
        $this->api_key = $this->params->def('api_key');
        $this->api_secret = $this->params->def('api_secret');
        $this->auth_token = $this->params->def('auth_token');
        $this->_desc_suffix = $this->params->def('desc_suffix');
    }
    /**
     * Wraps up after a call. Shows messages
     * @param string $response JSON response from FB
     */
    private function _wrapUp($response){
        $processedResponse = StileroFlickrResponse::handle($response);
        if(isset($processedResponse->photoid)){
            return $processedResponse->photoid;
        }else if($processedResponse == null){
            return false;
        }else{
            return false;
        }
    }
    /**
     * Cleans the tags and removes # and , to comply with Flickr.
     * @param string $tags
     * @return string Cleaned tags
     */
    private function _cleanTags($tags){
        $noHash = str_replace('#', '', $tags);
        $noComma = str_replace(',', ' ', $noHash);
        return $noComma;
    }
    /**
     * Posts an image to Flickr
     * @param string $url Full local url to the photo to upload
     * @param string $title The title of the photo.
     * @param string $description A description of the photo. May contain some limited HTML.
     * @param string $tags A space-seperated list of tags to apply to the photo.
     */
    public function postImage($url, $title, $description, $tags){
        //$this->Flickr = new StileroFlickr($this->api_key, $this->api_secret);
        $file = realpath(str_replace(JUri::root(), JPATH_ROOT.DS, $url));
        $this->Flickr = new StileroFlickr($this->api_key, $this->api_secret);
        $this->Flickr->setAccessToken($this->auth_token);
        $this->Flickr->init();
        $cleanedTags = $this->_cleanTags($tags);
        $response = $this->Flickr->Photouploader->upload($file, $title, $description, $cleanedTags);
        return $this->_wrapUp($response);
    }
    /**
     * Get all comments for Photo
     * @param integer $photo_id
     * @return string RAW JSON Response
     */
    public function getComments($photo_id){
        $this->Flickr = new StileroFlickr($this->api_key, $this->api_secret);
        $this->Flickr->setAccessToken($this->auth_token);
        $this->Flickr->init();
        $response = $this->Flickr->Photoscomments->getList($photo_id);
        $processedResponse = StileroFlickrResponse::handle($response);
        $comments = array();
        if(isset($processedResponse->comments->comment) && !empty($processedResponse->comments->comment)){
            foreach ($processedResponse->comments->comment as $comment) {
                $standardizedComment = new stdClass();
                $standardizedComment->time = StileroFlickrBoardhelper::timeToText($comment->datecreate);
                $standardizedComment->name = $comment->authorname;
                $standardizedComment->text = $comment->_content;
                $comments[] = $standardizedComment;
            }
        }
        return $comments;
    }
    
} //End Class