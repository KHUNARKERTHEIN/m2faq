<?php

/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Adminhtml\Faqgroup;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Ksolves\FAQ\Model\ResourceModel\Faq\CollectionFactory as FaqgroupCollection;

/**
* class MassStatus
*/
class MassStatus extends \Magento\Backend\App\Action
{
    /**
    * @var Filter
    */
    protected $filter;

    /**
    * @var FaqgroupCollection
    */
    protected $_collectionFactory;

    /**
    * @param Context $context
    * @param Filter $filter
    * @param FaqgroupCollection $collectionFactory
    */
    public function __construct(Context $context, Filter $filter, FaqgroupCollection $collectionFactory)
    {
        $this->filter = $filter;
        $this->_collectionFactory = $collectionFactory;
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
        $collection = $this->filter->getCollection($this->_collectionFactory->create());
        $kscollectionSize = $collection->getSize();

        foreach ($collection as $ksrecord) {
            $ksrecord->setStatus($this->getRequest()->getParam('status'))->save();
        }
        if ($this->getRequest()->getParam('status') == 1) {
            $status = 'enabled';
        } else {
            $status = 'disabled';
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been '.$status, $kscollectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/Faqgroup');
    }
}
