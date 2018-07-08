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

    	$installer->startSetup();
    	if (version_compare($context->getVersion(), "1.1.6", "<")) {
	    	
		    $tableName = $installer->getTable('opentechiz_blog_comment');
            $installer->getConnection()->addColumn($tableName, 'is_active', [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => false,
                'default' => 0,
                'comment' => 'Is Comment Active?'
            ]);
		}

    	$installer->endSetup();
    }
}