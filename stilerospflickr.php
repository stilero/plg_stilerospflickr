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

define('PATH_LIBRARY', dirname(__FILE__).DS.'library'.DS);
JLoader::discover('StileroSPFB', PATH_LIBRARY, false, true);
JLoader::discover('StileroSPFB', PATH_LIBRARY, false, true);
JLoader::discover('StileroSPFBOauth', PATH_LIBRARY.'fblibrary'.DS.'fboauth'.DS);
JLoader::discover('StileroSPFBOauth', PATH_LIBRARY.'fblibrary'.DS.'oauth'.DS);
JLoader::discover('StileroSPFBEndpoint', PATH_LIBRARY, false, true);
//JLoader::discover('StileroSPFBEndpoint', PATH_LIBRARY.'fblibrary'.DS.'endpoint'.DS, true);
//JLoader::discover('StileroSPFBOauth', PATH_LIBRARY.'fboauth', true, true);
JLoader::register('SocialpromoterImporter', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_socialpromoter'.DS.'helpers'.DS.'importer.php');
JLoader::register('SocialpromoterPosttype', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_socialpromoter'.DS.'library'.DS.'posttype.php');
//jimport('joomla.plugin.plugin');
jimport('joomla.event.plugin');

class plgSocialpromoterStilerospflickr extends JPlugin {
    protected $Facebook;
    protected $AccessToken;
    protected $Feed;
    protected $pageId;
    protected $adminId;
    protected $api_key;
    protected $api_secret;
    protected $auth_token;
    protected $_fbpageAuthToken;
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
        $this->setParams();
    }
        
    /**
     * Reads the params and sets them in the class 
     */
    protected function setParams(){
        if(!isset($this->params)){
            $plg = JPluginHelper::getPlugin('socialpromoter', 'stilerospflickr');
            $plg_params = new JRegistry();
            $plg_params->loadString($plg->params);
            $this->params = $plg_params;
        }
        $this->adminId = $this->params->def('fbadmin_id');
        $this->pageId = $this->params->def('fb_pages');
        $this->api_key = $this->params->def('api_key');
        $this->api_secret = $this->params->def('api_secret');
        $this->auth_token = $this->params->def('auth_token');
        $this->_desc_suffix = $this->params->def('desc_suffix');
    }
    
    /**
     * Checks if the post is to a personal wall or a page. It compares the page id
     * with the admin id, and if they mat
     * @return boolean true if personal post
     */
    protected function isPersonalPost(){
            $this->Facebook->User->setUserId('me');
            $me = $this->Facebook->User->me();
            $user = StileroSPFBOauthResponse::handle($me);
            if($user->id == $this->pageId){
                $this->Facebook->Photos->setUserId('me');
                $this->params->set('fb_pages', '');
                StileroSPFBPluginparamshelper::storeParams($this->params, 'autofbook');
                return true;
            }
    }
    
    /**
     * Wraps up after a call. Shows messages and updates tokens
     * @param string $response JSON response from FB
     */
    protected function wrapUp($response){
        $postResponse = StileroSPFBOauthResponse::handle($response);
        if(isset($postResponse->id)){
            return true;
        }else if($postResponse == null){
            return false;
        }else{
            return false;
        }
    }
    
    /**
     * Prepares for a FB Page call
     */
    protected function initFBPageCall(){
        $response = $this->Facebook->User->getTokenForPageWithId($this->pageId);
        $this->_fbpageAuthToken = StileroSPFBOauthResponse::handle($response);
        $this->Facebook->Photos->setToken($this->_fbpageAuthToken);
        $this->Facebook->Photos->setUserId($this->pageId);
    }
    
    public function postImage($url, $title='', $description='', $tags=''){
        $redirectUri = JURI::root();
        $this->Facebook = new StileroSPFBFacebook($this->api_key, $this->api_secret, $redirectUri);
        $this->Facebook->setAccessTokenFromToken($this->auth_token);
        $this->Facebook->init();
        $this->isPersonalPost();
        if($this->pageId != ''){
            if(!$this->isPersonalPost()){
                $this->initFBPageCall();
            }
        }else{
            $this->Facebook->Photos->setUserId('me');
        }
        $caption = $description.$this->_desc_suffix.' '.$tags;
        $response = $this->Facebook->Photos->publishFromUrl($url, $caption);
        return $this->wrapUp($response);
    }
    
} //End Class