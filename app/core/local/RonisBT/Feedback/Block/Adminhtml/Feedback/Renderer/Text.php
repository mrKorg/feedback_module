<?php

class RonisBT_Feedback_Block_Adminhtml_Feedback_Renderer_Text extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('label');
    }

    public function getElementHtml()
    {
        $html = $this->getBold() ? '<strong>' : '';
        $html.= $this->getEscapedValue();
        $html.= $this->getBold() ? '</strong>' : '';
        $html.= $this->getAfterElementHtml();
        return $html;
    }

    public function getLabelHtml($idSuffix = ''){
        if (!is_null($this->getLabel())) {
            $html = '<label for="'.$this->getHtmlId() . $idSuffix . '" style="'.$this->getLabelStyle().'">'.$this->getLabel()
                . ( $this->getRequired() ? ' <span class="required">*</span>' : '' ).'</label>'."\n";
        }
        else {
            $html = '';
        }
        return $html;
    }
}
