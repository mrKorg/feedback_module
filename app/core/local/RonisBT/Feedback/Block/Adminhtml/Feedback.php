<?php

class RonisBT_Feedback_Block_Adminhtml_Feedback extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_removeButton('add');
        $helper = Mage::helper('ronisbt_feedback');
        $this->_blockGroup = 'ronisbt_feedback';
        $this->_controller = 'adminhtml_feedback';
        $this->_headerText = $helper->__('Feedback editor');
    }
}
