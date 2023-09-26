<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */
namespace Ksolves\FAQ\Controller\Index;

/**
* class Index
*/
class Index extends \Magento\Framework\App\Action\Action
{

    /**
    * @var \Ksolves\FAQ\Helper\ConfigData
    */
    protected $helperData;

    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $_pageFactory;

   /**
   * Initialize Group Controller
   *
   * @param \Magento\Backend\App\Action\Context $context
   * @param \Ksolves\FAQ\Helper\ConfigData $helperData
   * @param \Magento\Framework\View\Result\PageFactory $pageFactory
   */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Ksolves\FAQ\Helper\ConfigData $helperData,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->helperData = $helperData;
        return parent::__construct($context);
    }
     
      /**
      * FAQ  action
      *
      * @return   \Magento\Framework\View\Result\PageFactory $pageFactory
      */
    public function execute()
    {
        $this->resultPage = $this->_pageFactory->create();
        $this->resultPage->getConfig()->getTitle()->set((__($this->helperData->getGeneralConfigData('display_text')))); 
        return $this->resultPage;
    }
}
