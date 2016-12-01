<?php

class RonisBT_Feedback_Model_Feedback extends Mage_Core_Model_Abstract
{
    /**
     * @var Email option
     */
    const XML_PATH_EMAIL_RECIPIENT  = 'ronisbt_feedback/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'ronisbt_feedback/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'ronisbt_feedback/email/email_template';
    const XML_PATH_ENABLED          = 'ronisbt_feedback/feedback/enabled';

    /**
     * @var Google reCaptcha Options
     */
    const URL        = 'ronisbt_feedback/captcha/captcha_url';
    const SECRETKEY  = 'ronisbt_feedback/captcha/captcha_secret';
    const SITEKEY    = 'ronisbt_feedback/captcha/captcha_site';
    const VERSION    = 'ronisbt_feedback/captcha/captcha_version';

    public function _construct()
    {
        parent::_construct();
        $this->_init('ronisbt_feedback/feedback');
    }

    /**
     * @param $post
     * @return bool
     */
    public function validateData($post)
    {
        if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
            return true;
        }

        if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
            return true;
        }

        if (!Zend_Validate::is(trim($post['subject']), 'NotEmpty')) {
            return true;
        } else if ($post['subject'] == RonisBT_Feedback_Model_Source_Subject::OTHER) {
            if (!Zend_Validate::is(trim($post['other_subject']), 'NotEmpty')) {
                return true;
            }
        }

        if (!Zend_Validate::is(trim($post['message']) , 'NotEmpty')) {
            return true;
        }
        return false;
    }

    /**
     * @param $post
     * @param $postObject
     * @return bool
     */
    public function sendEmail($email, $postObject)
    {
        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
        $mailTemplate->setDesignConfig(array('area' => 'frontend'))
            ->setReplyTo($email)
            ->sendTransactional(
                Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                null,
                array('data' => $postObject)
            );
        if(!$mailTemplate->getSentSuccess()){
            Mage::log('Mail don\'t send', null, 'system.log');
        }
    }

    /**
     * Save Form Data
     *
     * @return array
     */
    public function validateCaptcha($thisRequest)
    {
        $captcha = $thisRequest->getParam('g-recaptcha-response');
        $secret = Mage::getStoreConfig(self::SECRETKEY);
        $response = null;
        $path = Mage::getStoreConfig(self::URL);
        $dataC = array (
            'secret' => $secret,
            'remoteip' => Mage::helper('core/http')->getRemoteAddr(),
            'v' => Mage::getStoreConfig(self::VERSION),
            'response' => $captcha
        );
        $req = "";
        foreach ($dataC as $key => $value) {
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }
        // Cut the last '&'
        $req = substr($req, 0, strlen($req)-1);
        $response = file_get_contents($path . $req);
        $answers = json_decode($response, true);
        if(trim($answers ['success']) == true) {
            return true;
        }

        return false;
    }

    public function getSiteKey()
    {
        return Mage::getStoreConfig(self::SITEKEY);
    }

}
