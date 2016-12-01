<?php

class RonisBT_Feedback_Block_Adminhtml_Feedback_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('ronisbt_feedback');
        $model = Mage::registry('current_feedback');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $this->setForm($form);

        $fieldset = $form->addFieldset('feedback_form', array('legend' => $helper->__('Feedback Information')));

        $fieldset->addType('static_text','RonisBT_Feedback_Block_Adminhtml_Feedback_Renderer_Text');

        $fieldset->addField('name', 'static_text', array(
            'label'         => $helper->__('Name'),
            'name'          => 'name',
            'bold'          =>  true,
        ));

        $fieldset->addField('email', 'static_text', array(
            'label'         => $helper->__('Email'),
            'name'          => 'email',
            'bold'          =>  true,
        ));

        $fieldset->addField('phone', 'static_text', array(
            'label'         => $helper->__('Phone'),
            'name'          => 'phone',
            'bold'          =>  true,
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => $helper->__('Status'),
            'values'    => Mage::getModel('ronisbt_feedback/source_status')->toArray(),
            'name'      => 'status',
        ));

        $fieldset->addField('subject', 'static_text', array(
            'label'         => $helper->__('Subject'),
            'name'          => 'subject',
            'bold'          =>  true,
            'values' => Mage::getModel('ronisbt_feedback/source_subject')->toArray()
        ));

        $fieldset->addField('message', 'static_text', array(
            'label'         => $helper->__('Message'),
            'name'          => 'message',
            'bold'          =>  true,
        ));

        $fieldset->addField('user_agent', 'static_text', array(
            'label'         => $helper->__('User agent'),
            'name'          => 'user_agent',
            'bold'          =>  true,
        ));

        $fieldset->addField('remote_ip', 'static_text', array(
            'label'         => $helper->__('Remote IP'),
            'name'          => 'remote_ip',
            'bold'          =>  true,
        ));

        $fieldset->addField('created_at', 'static_text', array(
            'label'         => $helper->__('Date'),
            'name'          => 'created_at',
            'bold'          =>  true,
        ));

        $form->setUseContainer(true);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
