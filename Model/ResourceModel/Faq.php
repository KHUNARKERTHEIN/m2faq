<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Model\ResourceModel;

class Faq extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('ksolves_faqgroup', 'faqgroup_id');
    }
}
