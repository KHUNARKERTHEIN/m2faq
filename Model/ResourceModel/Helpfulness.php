<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Model\ResourceModel;

class Helpfulness extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('ksolvesfaq_helpfulness_voting', 'voting_id');
    }
}
