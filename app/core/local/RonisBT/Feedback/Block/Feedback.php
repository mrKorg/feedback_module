<?php

class RonisBT_Feedback_Block_Feedback extends Mage_Core_Block_Template
{

    /**
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('*/*/post');
    }

    public function getOldData()
    {
        return unserialize(Mage::getSingleton('core/session')->getRonisBTFeedback());
    }

    public function getAuth()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

    public function getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }

    public function getUserName()
    {
        if (self::getAuth()) {
            echo self::getCustomer()->getFirstname();
        } else if (self::getOldData()) {
            echo self::getOldData()['name'];
        }
    }

    public function getUserEmail()
    {
        if (self::getAuth()) {
            echo self::getCustomer()->getEmail();
        } else if (self::getOldData()) {
            echo $this->escapeHtml(self::getOldData()['email']);
        }
    }

    public function getUserPhone()
    {
        if (self::getOldData()) echo self::getOldData()['phone'];
    }

    public function getOtherSubject()
    {
        if (self::getOldData()) echo self::getOldData()['other_subject'];
    }

    public function getMessage()
    {
        if (self::getOldData()) echo self::getOldData()['message'];
    }

}
