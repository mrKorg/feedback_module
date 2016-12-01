<?php

class RonisBT_Feedback_Block_Adminhtml_Feedback_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId("cmsFeedbackGrid");
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ronisbt_feedback/feedback')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('ronisbt_feedback');

        $this->addColumn('feedback_id', array(
            'header'   => $helper->__('Feedback ID'),
            'index'    => 'feedback_id',
            'width'    => '30',
            'type'     => 'number'
        ));
        $this->addColumn('status', array(
            'header'   => $helper->__('Status'),
            'index'    => 'status',
            'type'     => 'options',
            'options'  => Mage::getModel('ronisbt_feedback/source_status')->toArray(),
            'width'    => '30'
        ));
        $this->addColumn('name', array(
            'header'   => $helper->__('Name'),
            'index'    => 'name',
            'type'     => 'text'
        ));
        $this->addColumn('email', array(
            'header'   => $helper->__('Email'),
            'index'    => 'email',
            'type'     => 'text'
        ));
        $this->addColumn('phone', array(
            'header'   => $helper->__('Phone'),
            'index'    => 'phone',
            'type'     => 'text'
        ));
        $this->addColumn('created_at', array(
            'header'   => $helper->__('Created at'),
            'index'    => 'created_at',
            'type'     => 'date',
            'width'    => '30'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('feedback_id');
        $this->getMassactionBlock()->setFormFieldName('feedback');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
