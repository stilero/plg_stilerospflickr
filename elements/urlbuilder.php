<?php
/**
* Description of AutoFBook
*
* @version  1.2
* @author Daniel Eliasson - joomla at stilero.com
* @copyright  (C) 2012-maj-20 Stilero Webdesign http://www.stilero.com
* @category Custom Form field
* @license    GPLv2
*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class for customising the register form field
 */
class JFormFieldUrlbuilder extends JFormField {
    
    protected $type = 'urlbuilder';
    
    /**
     * Returns the HTML for the form input
     * @return string HTML
     */
    protected function getInput(){
        $url = JUri::root().'plugins/socialpromoter/stilerospflickr/helpers/urlbuilder.php';
        $htmlCode = '<input id="'.$this->id.'" name="'.$this->name.'" type="hidden" class="text_area" size="9" value="'.$url.'"/>';
        return $htmlCode;
    }
    
    /**
     * Returns the Label HTML
     * @return string HTML
     */
    protected function getLabel(){
        $toolTip = JText::_($this->element['description']);
        $text = JText::_($this->element['label']);
        $labelHTML = '<label id="'.$this->id.'-lbl" for="'.$this->id.'" class="hasTip" title="'.$text.'::'.$toolTip.'">'.$text.'</label>';
        return;
        return $labelHTML;
    }
}//End Class
