<?php

class RonisBT_Feedback_Model_Source_Status
{

    const READ = '1';
    const UNREAD = '0';
    const SPAM = '2';

    /**
     * Options getter
     * @return array
     */

    public function toOptionArray()
    {
        return array(
            array('value' => self::READ, 'label' => 'Read'),
            array('value' => self::UNREAD, 'label' => 'Unread'),
            array('value' => self::SPAM, 'label' => 'Spam'),
        );
    }

    /**
     * Get options in "key-value" format
     * @return array
     */

    public function toArray()
    {
        return array(
            self::READ  => 'Read',
            self::UNREAD => 'Unread',
            self::SPAM => 'Spam'
        );
    }

}
