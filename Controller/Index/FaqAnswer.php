<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

 namespace Ksolves\FAQ\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

/**
* class FaqAnswer
*/
class FaqAnswer extends \Magento\Framework\App\Action\Action
{

    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $_pageFactory;

    protected $_urlRewriteFactory;

    protected $_storeManager;

    /**
    * \Ksolves\FAQ\Model\Post $Faq
    */
    protected $_Faq;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Ksolves\FAQ\Model\PostFactory $Faq,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory
    ) {

        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_urlRewriteFactory = $urlRewriteFactory;
        $this->_Faq = $Faq;
        return parent::__construct($context);

    }

    public function execute()
    {
        
        $_pageFactory = $this->_pageFactory->create();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $_pageFactory;

    }
}
