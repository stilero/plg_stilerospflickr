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

class StileroFlickrAuthtoken extends StileroFlickrCommunicator{
    
    public $token;
    protected $Api;
    protected $Frob;
    const API_CALL_URL = 'http://flickr.com/services/rest/';
    const API_METHOD = 'flickr.auth.getToken';
    
    public function __construct(StileroFlickrApi $Api, StileroFlickrFrob $Frob) {
        parent::__construct();
        $this->Api = $Api;
        $this->Frob = $Frob;
    }
        
    public function getToken(){
        $params = array(
            'method' => self::API_METHOD,
            'api_key' => $this->Api->key,
            'frob' => $this->Frob->frob
        );
        $signature = StileroFlickrSignature::getSignature($params, $this->Api);
        $params['api_sig'] = $signature;
        $this->setPostVars($params);
        $this->setUrl(self::API_CALL_URL);
        $this->query();
        return $this->getResponse();
    }
}
