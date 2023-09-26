<?php
/**
* @author Ksolves Team
* @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
* @package Ksolves_FAQ
*/
namespace Ksolves\FAQ\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $date;

    public function __construct(\Magento\Framework\Stdlib\DateTime\DateTime $date)
    {
        $this->date = $date;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $datafaqRows = [
            [
                'faq_id' => '',
                'faq' => 'Sample FAQ',
                'content' => '<p>Sample content for the FAQ</p>',
                'faqgroup_id'=>'1',
                'image'=>'',
                'url'=>'https://www.youtube.com/embed/tgbNymZ7vqY',
                'url_key'=> 'sample',
                'sort_order' => '1',
                'status' => 1,
            ]
        ];
        
        /*
        * Install Data in 'ksolves_faq Table
        */
        foreach ($datafaqRows as $faqdata) {
            $setup->getConnection()->insert($setup->getTable('ksolves_faq'), $faqdata);
        }

        $datafaqgroupRows = [
            [
                'faqgroup_id' => '',
                'group_name' => 'Group1',
                'group_code' => 'ks-gp1',
                'width'=>'200',
                'status' => 1,
            ]
        ];
                            /**
                             * Install Data in 'ksolves_faqgroup Table
                             */
        foreach ($datafaqgroupRows as $faqgroupdata) {
            $setup->getConnection()->insert($setup->getTable('ksolves_faqgroup'), $faqgroupdata);
        }
    }
}
