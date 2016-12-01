<?php

class RonisBT_Feedback_Adminhtml_FeedbackController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('cms/ronisbt_feedback');
        $this->_addContent($this->getLayout()->createBlock('ronisbt_feedback/adminhtml_feedback'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        Mage::register('current_feedback', Mage::getModel('ronisbt_feedback/feedback')->load($id));
        $model = Mage::getModel('ronisbt_feedback/feedback')->load($id);
        if ($model->getStatus() != RonisBT_Feedback_Model_Source_Status::SPAM) {
            $model->setStatus(RonisBT_Feedback_Model_Source_Status::READ);
            $model->save();
        }
        $this->loadLayout()->_setActiveMenu('cms/ronisbt_feedback');
        $this->_addContent($this->getLayout()->createBlock('ronisbt_feedback/adminhtml_feedback_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('ronisbt_feedback/feedback');
                $model->setData($data)->setId($id)->setStatus($data['status']);
                $model->save();
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $id));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('ronisbt_feedback/feedback')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Feedback was deleted successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $feedback = $this->getRequest()->getParam('feedback', null);

        if (is_array($feedback) && sizeof($feedback) > 0) {
            try {
                foreach ($feedback as $id) {
                    Mage::getModel('ronisbt_feedback/feedback')->setId($id)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d feedback have been deleted', sizeof($feedback)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $this->_getSession()->addError($this->__('Please select feedback'));
        }
        $this->_redirect('*/*');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('ronisbt_feedback/adminhtml_feedback_grid')->toHtml()
        );
    }

}
