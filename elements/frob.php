<?php
/**
* Frob
*
* @version  1.0
* @author Daniel Eliasson <daniel at stilero.com>
* @copyright  (C) 2014-jan-02 Stilero Webdesign (http://www.stilero.com)
* @category Custom Form field
* @license    GPLv2
*
*
*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');
class frob{
    
}

class JFormFieldFrob extends JFormField {
    protected $type = 'frob';

    protected function getInput(){
        $jinput = JFactory::getApplication()->input;
        $value = $jinput->get('frob', '');
        if($value != ''){
            $this->value = $jinput->get('frob', '');
        }
        $htmlCode = '<input id="'.$this->id.'" name="'.$this->name.'" type="hidden" class="text_area" size="9" value="'.$this->value.'"/>';
        return $htmlCode;
    }

    protected function getLabel(){
        $toolTip = JText::_($this->element['description']);
        $text = JText::_($this->element['label']);
        $labelHTML = '<label id="'.$this->id.'-lbl" for="'.$this->id.'" class="hasTip" title="'.$text.'::'.$toolTip.'">'.$text.'</label>';
        return;
        return $labelHTML;
    }

}//End Class