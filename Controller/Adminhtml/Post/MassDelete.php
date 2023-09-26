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
use Ksolves\FAQ\Model\ResourceModel\Post\CollectionFactory as Faqcollection;

/**
* class MassDelete
*/
class MassDelete extends \Magento\Backend\App\Action
{
    /**
    * @var Filter
    */
    protected $filter;

    /**
    * @var Faqcollection
    */
    protected $collectionFactory;

    /**
    * @param Context $context
    * @param Filter $filter
    * @param Faqcollection $collectionFactory
    */
    public function __construct(Context $context, Filter $filter, Faqcollection $collectionFactory)
    {
        $this->filter = $filter;
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
        $ksCollection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $ksCollection->getSize();

        foreach ($ksCollection as $record) {
            $record->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
