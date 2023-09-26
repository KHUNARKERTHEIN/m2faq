<?php

namespace Ksolves\FAQ\Controller;

use Magento\Framework\App\RequestInterface;
use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class Router implements \Magento\Framework\App\RouterInterface
{

    private $actionFactory;

    /**
     * @var UrlFinderInterface
     */
    protected $urlFinder;

    protected $_Faq;

    /**
     * Router constructor.
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     */

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResponseInterface $response,
        UrlFinderInterface $urlFinder,
        \Ksolves\FAQ\Model\PostFactory $Faq
    ) {
        $this->_Faq = $Faq;
        $this->actionFactory = $actionFactory;
        $this->storeManager = $storeManager;
        $this->response = $response;
        $this->urlFinder = $urlFinder;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $words = explode('/', $identifier);
        $len = sizeof($words);
        $urlkey = $words[$len - 1];
        if ($words[0] == 'ksfaq') {

            $faqData = $this->_Faq->create()->getCollection()->addFieldToFilter('url_key', $urlkey)->getData();

            if (sizeof($faqData)) {
             
                $request->setModuleName('ksfaq')->setControllerName('index')->setActionName('faqanswer')->setParam('faq_id', $faqData[0]['faq_id']);
            } else {
                //There is no match
                return;
            }

            /*
            * We have match and now we will forward action
            */
            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );

        } else {
            return;
        }
        
    }
}
