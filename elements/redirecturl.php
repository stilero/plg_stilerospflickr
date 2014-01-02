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
class JFormFieldRedirecturl extends JFormField {
    
    protected $type = 'urlbuilder';
    
    private function getPluginId(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('extension_id')->from('#__extensions');
        $query->where('type='.$db->q('plugin'));
        $query->where('folder='.$db->q('socialpromoter'));
        $query->where('element='.$db->q('stilerospflickr'));
        $db->setQuery($query);
        $result = $db->loadObject();
        return $result->extension_id;
    }
    
    private function getPluginUrl(){
        $id = $this->getPluginId();
        //$url = JUri::root().'administrator/index.php?option=com_plugins&task=plugin.edit&extension_id='.(int)$id;
        $url = JUri::root().'administrator/index.php?option=com_plugins&view=plugin&layout=edit&extension_id='.(int)$id;
        return $url;
    }
    
    private function getPluginUrlWithToken(){
        $token = JSession::getFormToken();
        $url = $this->getPluginUrl();
        $urlWithToken=$url.'&'.$token.'=1';
        return $urlWithToken;
    }
    
    /**
     * Returns the HTML for the form input
     * @return string HTML
     */
    protected function getInput(){
        
        $url = $this->getPluginUrlWithToken();
        
        //$url = JUri::root().'plugins/socialpromoter/stilerospflickr/helpers/frob.php';
        $htmlCode = '<input id="'.$this->id.'" name="'.$this->name.'" type="text" class="text_area" size="9" value="'.$url.'"/>';
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
        return $labelHTML;
    }
}//End Class
