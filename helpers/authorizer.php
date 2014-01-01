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
define('PATH_FBLIBRARY_AUTH', '..'.DS.'library'.DS.'authentication'.DS);
define('PATH_FBLIBRARY_OAUTH', '..'.DS.'library'.DS.'oauth'.DS);
require_once PATH_FBLIBRARY_OAUTH.'communicator.php';
require_once PATH_FBLIBRARY_OAUTH.'client.php';
require_once PATH_FBLIBRARY_AUTH.'authtoken.php';
require_once PATH_FBLIBRARY_AUTH.'frob.php';
require_once PATH_FBLIBRARY_OAUTH.'api.php';
require_once PATH_FBLIBRARY_OAUTH.'jerror.php';
require_once PATH_FBLIBRARY_OAUTH.'response.php';
$api_key = StileroSPFBOauthCode::sanitizeInt($_POST['api_key']);
$api_secret = StileroSPFBOauthCode::sanitizeString($_POST['api_secret']);
$frob = StileroSPFBOauthCode::sanitizeString($_POST['frob']);
$redirectURI = StileroSPFBOauthCode::sanitizeUrl($_POST['redirect_uri']);
$Api = new StileroSPFBOauthApp($api_key, $api_secret);
$AuthToken = new StileroFlickrAuthtoken($Api);
$json = $AuthToken->getTokenFromCode($frob, $redirectURI);
$response = StileroSPFBOauthResponse::handle($json);
$AuthToken->tokenFromResponse($response);
$token = $AuthToken->token;
if($AuthToken->isShortTerm($token)){
    $json = $AuthToken->extend();
    $response = StileroSPFBOauthResponse::handle($json);
    $AuthToken->tokenFromResponse($response);
    $token = $AuthToken->token;
}
$jsonResponse = <<<EOD
{
   "access_token": "$token"
}
EOD;
    print $jsonResponse;
?>