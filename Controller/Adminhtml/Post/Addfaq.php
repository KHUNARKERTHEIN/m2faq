<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Adminhtml\Post;

/**
* class Addfaq
* Here Post is for FAQ
*/
class Addfaq extends \Magento\Backend\App\Action
{
    /**
    * $resultPageFactory
    */
    protected $resultPageFactory = false;

    /**
    * @param \Magento\Backend\App\Action\Context $context
    * @param Magento\Framework\View\Result\PageFactory $resultPageFactory
    */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
    * FAQ  action
    *
    * @return \Magento\Framework\View\Result\$resultPageFactory
    */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Add FAQ')));
        return $resultPage;
    }
}
