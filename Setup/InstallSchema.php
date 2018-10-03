<?php
namespace IdealCode\Banner\Setup;

use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    const TABLE_ITEMS = 'ic_banner_items';
    const TABLE_TYPES = 'ic_banner_types';

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    )
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'ic_banner_items'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::TABLE_ITEMS)
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
        )->addColumn(
            'active',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1']
        )->addColumn(
            'sort',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true]
        )->addColumn(
            'type_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false]
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            null,
            []
        )->addColumn(
            'img',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false]
        )->addColumn(
            'link',
            Table::TYPE_TEXT,
            255,
            []
        )->addForeignKey(
            $installer->getFkName(
                self::TABLE_ITEMS,
                'type_id',
                self::TABLE_TYPES,
                'id'
            ),
            'type_id',
            $installer->getTable(self::TABLE_TYPES),
            'id',
            Table::ACTION_CASCADE
        );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::TABLE_TYPES)
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false]
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
