<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Adminhtml\Post;

// Here Post is for FAQ


use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Ksolves\FAQ\Model\ResourceModel\Post\CollectionFactory as FaqCollection;

/**
* class MassStatus
*/
class MassStatus extends \Magento\Backend\App\Action
{
    /**
    * @var Filter
    */
    protected $ksfilter;

    /**
    * @var FaqCollection
    */
    protected $collectionFactory;

    /**
    * @param Context $context
    * @param Filter $filter
    * @param FaqCollection $collectionFactory
    */
    public function __construct(Context $context, Filter $ksfilter, FaqCollection $collectionFactory)
    {
        $this->filter = $ksfilter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
    * Execute action
    *
    * @return \Magento\Backend\Model\View\Result\Redirect
    * @throws \Magento\Framework\Exception\LocalizedException|\Exception
    */
    public function execute()
    {
        $ksfaqCollection = $this->filter->getCollection($this->collectionFactory->create());
        $faqCollectionSize = $ksfaqCollection->getSize();

        foreach ($ksfaqCollection as $record) {
            $record->setStatus($this->getRequest()->getParam('status'))->save();
        }
        if ($this->getRequest()->getParam('status') == 1) {
            $ksstatus = 'enabled';
        } else {
            $ksstatus = 'disabled';
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been '.$ksstatus, $faqCollectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
