<?php
/**
 * Flickr_API
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Flickr_API
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2014-jan-02 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrXmltojson{
    
    /**
     * Parses a XML string and converts it to JSON
     * @param string $xml XML String
     * @return type
     */
    public static function parse ($xml) {
        $strippedLinebreaks = str_replace(array("\n", "\r", "\t"), '', $xml);
        $trimmed = trim(str_replace('"', "'", $strippedLinebreaks));
        $simpleXml = simplexml_load_string($trimmed);
        $json = json_encode($simpleXml);
        $jsonNoIllegalChars = str_replace("@attributes", 'attributes', $json);
        return $jsonNoIllegalChars;
    }
}
