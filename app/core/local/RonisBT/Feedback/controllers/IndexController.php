<?php

class RonisBT_Feedback_IndexController extends Mage_Core_Controller_Front_Action
{

    public function preDispatch()
    {
        parent::preDispatch();

        if( !Mage::getStoreConfigFlag(RonisBT_Feedback_Model_Feedback::XML_PATH_ENABLED) ) {
            $this->norouteAction();
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
        Mage::getSingleton('core/session')->getRonisBTFeedback(true);
    }

    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        $model = Mage::getModel('ronisbt_feedback/feedback');

        if ( $post ) {
            try {

                if ($model->validateData($post)) {
                    throw new Exception();
                }

                if (!$model->validateCaptcha($this->getRequest())) {
                    throw new Exception();
                }

                $arrSubject = Mage::getModel('ronisbt_feedback/source_status')->toArray();
                $otherSubject = RonisBT_Feedback_Model_Source_Subject::OTHER;
                $currentSubject = $arrSubject[$post['subject']];
                if ($post['subject'] == $otherSubject) {
                    $currentSubject = $post['other_subject'];
                }

                $postObject = new Varien_Object();
                $postObject->setData($post);

                $model->setName($post['name'])->setEmail($post['email'])->setSubject($currentSubject)->setMessage($post['message'])->setPhone($post['phone'])
                    ->setUserAgent(Mage::helper('core/http')->getHttpUserAgent())
                    ->setRemoteIp(Mage::helper('core/http')->getRemoteAddr());
                if(Mage::getSingleton('customer/session')->isLoggedIn()) {
                    $customerData = Mage::getSingleton('customer/session')->getCustomer();
                    $model->setCustomerId($customerData->getId());
                }
                $model->save();

                $model->sendEmail($post['email'], $postObject);

                Mage::getSingleton('core/session')
                    ->addSuccess(Mage::helper('ronisbt_feedback')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'))
                    ->unsetPostRonisBTFeedback();
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {

                Mage::getSingleton('core/session')
                    ->addError(Mage::helper('ronisbt_feedback')->__('Unable to submit your request. Please, try again later'))
                    ->setRonisBTFeedback(serialize($post));
                $this->_redirect('*/*/');


                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }

    protected function _beforeSave()
    {
        if ($this->isObjectNew()) {
            $this->setCreatedAt(Mage::app()->getLocale()->storeDate('', null, true));
        }
    }

}
