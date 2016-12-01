<?php

class RonisBT_Feedback_Model_Source_Subject
{

    const OTHER    = 'Other subject';
    const SUBJECT1 = 'Subject 1';
    const SUBJECT2 = 'Subject 2';
    const SUBJECT3 = 'Subject 3';
    const SUBJECT4 = 'Subject 4';

    /**
     * Options getter
     * @return array
     */

    public function toOptionArray()
    {
        return array(
            array('value' => self::SUBJECT1, 'label' => self::SUBJECT1),
            array('value' => self::SUBJECT2, 'label' => self::SUBJECT2),
            array('value' => self::SUBJECT3, 'label' => self::SUBJECT3),
            array('value' => self::SUBJECT4, 'label' => self::SUBJECT4),
            array('value' => self::OTHER,    'label' => self::OTHER),
        );
    }

    /**
     * Get options in "key-value" format
     * @return array
     */

    public function toArray()
    {
        return array(
            'subject-1'  => self::SUBJECT1,
            'subject-2'  => self::SUBJECT2,
            'subject-3'  => self::SUBJECT3,
            'subject-4'  => self::SUBJECT4,
            'other'      => self::OTHER,
        );
    }


    /**
     * @param $key
     * @return mixed
     */
    public function getSubject($key)
    {
        return $this->toArray()[$key];
    }

}
