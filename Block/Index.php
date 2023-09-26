<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Block;

/**
* class Index
*/
class Index extends \Magento\Framework\View\Element\Template
{
    /**
    * @var \Magento\Framework\ObjectManagerInterface $_objectManager
    */
    private $_objectManager;

    /**
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Magento\Framework\ObjectManagerInterface $objectManager
    * @param \Ksolves\FAQ\Helper\ConfigData $helperData
    */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Ksolves\FAQ\Helper\ConfigData $helperData
    ) {
                $this->helperData = $helperData;
                $this->_objectManager = $objectmanager;
                parent::__construct($context);
    }

    /**
    * Module Status
    * @return Int
    */

    public function getModuleStatus()
    {
        return $this->helperData->getGeneralConfigData('enable');
    }

    /**
    *  Text
    * @return String
    */

    public function getText()
    {
        return  $this->helperData->getGeneralConfigData('display_text');
    }

    /**
    *  Text
    * @return String
    */

    public function getCrete()
    {
        return $this->_objectManager->create('Ksolves\FAQ\Model\Faq');
    }

    /**
    *  Text
    * @return String
    */

    public function allowTopLink()
    {
        return $this->helperData->getGeneralConfigData('allow_toplink');
    }

    /**
    *  Text
    * @return String
    */

    public function allowFooterLink()
    {
        return $this->helperData->getGeneralConfigData('allow_footerlink');
    }

    /**
     * redirect contoller to home 
     * @return void
     */
    public function getRedirect()
    {
        $store = $this->_storeManager->getStore();
        $redirect = $this->_objectManager->get('\Magento\Framework\App\Response\Http');
        $redirect->setRedirect($store->getBaseUrl());
        return ;
    }
}
