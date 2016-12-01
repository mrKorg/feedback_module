<?php

/** @var Mage_Core_Model_Resource_Setup $installer */

$installer = $this;
$tableFeedback = $installer->getTable('ronisbt_feedback/table_feedback');

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($tableFeedback)
    ->addColumn('feedback_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary'  => true
    ))
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'default' => RonisBT_Feedback_Model_Source_Status::UNREAD
    ))
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, '255')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, '255')
    ->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, '255')
    ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_TEXT, null)
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null)
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null)
    ->addForeignKey(
        $installer->getFkName('ronisbt_feedback/table_feedback', 'customer_id', 'customer/entity','entity_id'),
        'customer_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addColumn('user_agent', Varien_Db_Ddl_Table::TYPE_TEXT, null)
    ->addColumn('remote_ip', Varien_Db_Ddl_Table::TYPE_TEXT, '255')
    ->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, '255')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null)
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null);

$installer->getConnection()->createTable($table);

$installer->endSetup();




