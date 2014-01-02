<?php
/**
 * Authorizing methods - Contacts FB and exchanges tokens
 * @version 1.1
 * @package AutoFBook Plugin
 * @author    Daniel Eliasson Stilero AB - http://www.stilero.com
 * @copyright	Copyright (c) 2011 Stilero AB. All rights reserved.
 * @license	GPLv2
 * 
*/
// no direct access
define('_JEXEC', 1); 
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
define('PATH_FLICKR_LIBRARY_AUTH', '..'.DS.'library'.DS.'authentication'.DS);
define('PATH_FLICKR_LIBRARY_OAUTH', '..'.DS.'library'.DS.'oauth'.DS);
define('PATH_FLICKR_LIBRARY_HELPERS', '..'.DS.'library'.DS.'helpers'.DS);
require_once PATH_FLICKR_LIBRARY_OAUTH.'communicator.php';
//require_once PATH_FLICKR_LIBRARY_OAUTH.'client.php';
require_once PATH_FLICKR_LIBRARY_AUTH.'authtoken.php';
require_once PATH_FLICKR_LIBRARY_AUTH.'frob.php';
require_once PATH_FLICKR_LIBRARY_OAUTH.'api.php';
require_once PATH_FLICKR_LIBRARY_OAUTH.'jerror.php';
require_once PATH_FLICKR_LIBRARY_OAUTH.'response.php';
require_once PATH_FLICKR_LIBRARY_OAUTH.'signature.php';
require_once PATH_FLICKR_LIBRARY_HELPERS.'sanitizer.php';

$api_key = StileroFlickrSanitizer::sanitizeString($_POST['api_key']);
$api_secret = StileroFlickrSanitizer::sanitizeString($_POST['api_secret']);
$frob = StileroFlickrSanitizer::sanitizeString($_POST['frob']);
//$redirectURI = StileroSPFBOauthCode::sanitizeUrl($_POST['redirect_uri']);
$Api = new StileroFlickrApi($api_key, $api_secret);
$Frob = new StileroFlickrFrob();
$Frob->setFrob($frob);
$AuthToken = new StileroFlickrAuthtoken($Api, $Frob);
$token = $AuthToken->requestToken();
$jsonResponse = <<<EOD
{
   "access_token": "$token"
}
EOD;
    print $jsonResponse;
?>