<?php
/**
 * Class for cleaning and sanitizing strings
 *
 * @version  1.0
 * @package Stilero
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2013-dec-18 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrSanitizer{
    
    const PREG_PATTERN_STRING = '/[^A-Z0-9_\.-]/i';
    const PREG_PATTERN_INT = '/[^A-Z0-9_\.-]/i';
    const PREG_PATTERN_URL = '/[^A-Z0-9_\.-]/i';
    
    /**
     * Cleans and sanitizes a string
     * @param string $string The string to sanitize
     * @param string $preg_pattern Preg pattern to use (use constants of this class)
     * @param string $filter Filter var constant
     * @return string Cleaned and sanitized
     */
    private static function _sanitize($string, $preg_pattern, $filter){
        $cleaned = (string) preg_replace($preg_pattern, '', $string);
        $trimmed = ltrim($cleaned, '.');
        $filtered = filter_var($trimmed, $filter);
        return $filtered;
    }
    /**
     * Cleans strings and strips out unwanted characters
     * @param string $string
     * @return string cleaned and sanitized string
     */
    public static function sanitizeString($string){
        return self::_sanitize($string, self::PREG_PATTERN_STRING, FILTER_SANITIZE_STRING);
    }
    
    /**
     * Cleans ints and strips out unwanted characters
     * @param string $string
     * @return string cleaned string
     */
    public static function sanitizeInt($string){
        return self::_sanitize($string, self::PREG_PATTERN_INT, FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     * Cleans urls and strips out unwanted characters
     * @param string $string
     * @return string cleaned string
     */
    public static function sanitizeUrl($string){
        return self::_sanitize($string, self::PREG_PATTERN_URL, FILTER_SANITIZE_URL);
    }
}