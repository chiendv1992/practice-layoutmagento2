<?php
namespace OpenTechiz\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
        $installer = $setup;

       $table = $installer->getConnection()
           ->newTable($installer->getTable('opentechiz_post_comment'))
           ->addColumn(
               'comment_id',
               Table::TYPE_SMALLINT,
               null,
               ['identity' => true, 'nullable' => false, 'primary' => true],
               'Comment ID'
           )
           ->addColumn('content', Table::TYPE_TEXT, 255, ['nullable => false'], 'Comment Content')
           ->addColumn('author', Table::TYPE_TEXT, 255, ['nullable => false'], 'Comment Author')
           ->addColumn('post_id', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Post ID')
           ->addColumn('creation_time', Table::TYPE_TIMESTAMP, null,[
               'nullable' => false,
               'default' => Table::TIMESTAMP_INIT
           ], 'Comment Created At')
           ->setComment('Comment Table');

       $installer->getConnection()->createTable($table);

       $tableName = $installer->getTable('opentechiz_post_comment');
       $installer->getConnection()->addColumn($tableName, 'is_active', [
           'type' => Table::TYPE_SMALLINT,
           'nullable' => false,
           'default' => 0,
           'comment' => 'Comment Status?'
       ]);

       $tableName = $installer->getTable('opentechiz_post_comment');
       $installer->getConnection()->addColumn($tableName, 'email', [
           'type' => Table::TYPE_TEXT,
           'length' => 255,
           'nullable' => false,
           'comment' => 'Email'
       ]);
       $tableName = $installer->getTable('opentechiz_post_comment');
       $installer->getConnection()->addColumn($tableName, 'user_id', [
           'type' => Table::TYPE_SMALLINT,
           'nullable' => false,
           'default' => 0,
           'comment' => 'Id of user'
       ]);
        $table = $installer->getConnection()
            ->newTable($installer->getTable('opentechiz_notification_approve'))
            ->addColumn(
                'noti_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Notification ID'
            )
            ->addColumn('content', Table::TYPE_TEXT, 255, ['nullable => false'], 'Notification Content')
            ->addColumn('user_id', Table::TYPE_SMALLINT, null, ['nullable' => false], 'User ID')
            ->addColumn('cmt_id', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Comment ID')
            ->addColumn('post_id', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Post ID')
            ->addColumn('creation_time', Table::TYPE_TIMESTAMP, null,[
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT
            ], 'Notification Created At')
            ->setComment('Notification Approve Table');
        $installer->getConnection()->createTable($table);
    	$installer->endSetup();


    }
}