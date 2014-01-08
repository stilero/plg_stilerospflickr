<?php
/**
 * Instaboard
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Instaboard
 * @author Daniel Eliasson - joomla at stilero.com
 * @copyright  (C) 2012-okt-23 Stilero Webdesign http://www.stilero.com
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrBoardhelper{
    
    const DAY_IN_SEC = 86400;
    const HOUR_IN_SEC = 3600;
    const MINUTE_IN_SEC = 60;
    const DAY = 'd';
    const HOUR = 'h';
    const MIN = 'm';
    const SEC = 's';
    
    public static function timeToText($timestamp){
        $now = time();
        $diff = $now - $timestamp;
        if($diff < self::MINUTE_IN_SEC){
            return floor($diff).self::SEC;
        }elseif($diff >= self::MINUTE_IN_SEC && $diff < self::HOUR_IN_SEC){
            return floor($diff/self::MINUTE_IN_SEC).self::MIN;
        }elseif($diff >= self::HOUR_IN_SEC && $diff < self::DAY_IN_SEC){
            return floor($diff/self::HOUR_IN_SEC).self::HOUR;
        }elseif($diff >= self::DAY_IN_SEC){
            return floor($diff/self::DAY_IN_SEC).self::DAY;
        }
    }
    /**
     * Replaces #tags and @users with Links and labels.
     * @param string $text
     * @return string Transformed text
     */
    public static function transformTagsAndUsers($text){
        return $text;
    }
            
}
