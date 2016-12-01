<?php

class RonisBT_Feedback_Block_Adminhtml_Feedback_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();
        $this->_removeButton('reset');
        $this->_removeButton('add');
        $this->_blockGroup = 'ronisbt_feedback';
        $this->_controller = 'adminhtml_feedback';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('ronisbt_feedback');
        $model = Mage::registry('current_feedback');
        return $helper->__("Read feedback " . $model->getName());
    }

}
