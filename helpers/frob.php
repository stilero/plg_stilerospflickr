<?php
/**
 * Url builder
 *
 * @version  1.0
 * @package Stilero
 * @subpackage plg_stilerospflickr
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2014-jan-02 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
define('_JEXEC', 1); 
// no direct access
defined('_JEXEC') or die('Restricted access'); 

if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
define('_JEXEC', 1);

define('PATH_FLICKR_LIBRARY_AUTH', '..'.DS.'library'.DS.'authentication'.DS);
define('PATH_FLICKR_LIBRARY_OAUTH', '..'.DS.'library'.DS.'oauth'.DS);
define('PATH_FLICKR_LIBRARY_HELPERS', '..'.DS.'library'.DS.'helpers'.DS);
require_once PATH_FLICKR_LIBRARY_AUTH.'frob.php';
//require_once PATH_FLICKR_LIBRARY_OAUTH.'api.php';
//require_once PATH_FLICKR_LIBRARY_OAUTH.'signature.php';
require_once PATH_FLICKR_LIBRARY_HELPERS.'sanitizer.php';

$Frob = new StileroFlickrFrob();
$Frob->fetchFrob();
print $Frob->frob;
