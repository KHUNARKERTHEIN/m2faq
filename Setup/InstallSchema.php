<?php
/**
* @author Ksolves Team
* @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
* @package Ksolves_FAQ
*/

namespace Ksolves\FAQ\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $conn = $setup->getConnection();

        /**
        * Create table 'Ksolves Faq'
        */
        $tableName = $setup->getTable('ksolves_faq');
        if ($conn->isTableExists($tableName) != true) {
            $table = $conn->newTable($tableName)
            ->addColumn(
                'faq_id',
                Table::TYPE_INTEGER,
                11,
                ['identity'=>true,'unsigned'=>true,
                'nullable'=>false,'primary'=>true],
                'Faq Id'
            )
            ->addColumn(
                'faq',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>'']
            )
            ->addColumn(
                'content',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '2M',
                ['nullable' => true,'default' => null],
                'Content'
            )
            ->addColumn(
                'faqgroup_id',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Faqgroup Id'
            )
            ->addColumn(
                'meta_title',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Meta Title'
            )
            ->addColumn(
                'meta_description',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Meta Description'
            )
            ->addColumn(
                'url_key',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'URL Key'
            )
            ->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>'']
            )

            ->addColumn(
                'url',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>'']
            )
            ->addColumn(
                'sort_order',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Sort Order'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                ['default' => true],
                'Status'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )
            ->addColumn(
                'helpful_votes',
                Table::TYPE_INTEGER,
                11,
                ['unsigned'=>true, 'nullable'=>false,],
                'Helpful Votes'
            )
            ->addColumn(
                'total_votes',
                Table::TYPE_INTEGER,
                11,
                ['unsigned'=>true, 'nullable'=>false,],
                'Total Votes'
            )
            ->addColumn(
                'helpfulness_rate',
                Table::TYPE_DECIMAL,
                '10,2',
                ['nullable'=> false, 'default'=>'0.00'],
                'Decimal'
            )
            ->setOption('charset', 'utf8');
            $conn->createTable($table);

            $conn->addIndex(
                $setup->getTable('ksolves_faq'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faq'),
                    ['sort_order'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['sort_order'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );

            $conn->addIndex(
                $setup->getTable('ksolves_faq'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faq'),
                    ['url_key'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['url_key'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );

            $conn->addIndex(
                $setup->getTable('ksolves_faq'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faq'),
                    ['faq'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['faq'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
             $conn->addIndex(
                $setup->getTable('ksolves_faq'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faq'),
                    ['faq', 'url_key'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['faq', 'url_key'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

            /**
             * Create table 'Ksolves FaqGroup'
             */
            $tableName = $setup->getTable('ksolves_faqgroup');
        if ($conn->isTableExists($tableName) != true) {
            $table = $conn->newTable($tableName)

            ->addColumn(
                'faqgroup_id',
                Table::TYPE_INTEGER,
                null,
                ['identity'=>true,'unsigned'=>true,'nullable'=>false,'primary'=>true],
                'Faqgroup Id'
            )
            ->addColumn(
                'group_name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Group Name'
            )
            ->addColumn(
                'group_code',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Group Code'
            )
            ->addColumn(
                'width',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>'']
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                ['default' => true],
                'Status'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )

            ->setOption('charset', 'utf8');
            $conn->createTable($table);

            $conn->addIndex(
                $setup->getTable('ksolves_faqgroup'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faqgroup'),
                    ['group_name', 'group_code'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['group_name', 'group_code'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            $conn->addIndex(
                $setup->getTable('ksolves_faqgroup'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faqgroup'),
                    ['group_name'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['group_name'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );

            $conn->addIndex(
                $setup->getTable('ksolves_faqgroup'),
                $setup->getIdxName(
                    $setup->getTable('ksolves_faqgroup'),
                    ['group_code'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['group_code'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
        }

        /**
             * Create table 'ksolvesfaq_helpfulness_voting'
             */
            $tableName = $setup->getTable('ksolvesfaq_helpfulness_voting');
        if ($conn->isTableExists($tableName) != true) {
            $table = $conn->newTable($tableName)

            ->addColumn(
                'voting_id',
                Table::TYPE_INTEGER,
                null,
                ['identity'=>true,'unsigned'=>true,'nullable'=>false,'primary'=>true],
                'Primary Key'
            )

            ->addColumn(
                'faq_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned'=>true,'nullable'=>false],
                'foreign key'
            )
            ->addColumn(
                'user_email',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'user email'
            )
            ->addColumn(
                'user_ip',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'user ip'
            )
            ->addColumn(
                'helpfulness',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                ['default' => true],
                'Helpfulness'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )
            ->addForeignKey(
                $setup->getFkName(
                    $setup->getTable('ksolvesfaq_helpfulness_voting'),
                    'faq_id',
                    $setup->getTable('ksolves_faq'),
                    'faq_id'
                ),
                'faq_id',
                $setup->getTable('ksolves_faq'),
                'faq_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
             
            ->setOption('charset', 'utf8');
            $conn->createTable($table);
        }


            $setup->endSetup();
    }
}
