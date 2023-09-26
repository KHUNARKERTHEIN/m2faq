<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Adminhtml\Faqgroup;

/**
* class Edit
*/
class Edit extends \Ksolves\FAQ\Controller\Adminhtml\Faq
{
    /**
    * @return $resultPageFactory
    */
    public function execute()
    {
        $id = $this->getRequest()->getParam('faqgroup_id');

        $model = $this->_objectManager->create('Ksolves\FAQ\Model\Faq');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $this->_redirect('ksolves_faq/Faqgroup');
                return;
            }
        }
        // set entered data if was error when we do save
        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend((__('Update FAQ Group')));

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);

        if (!empty($data)) {
            $model->addData($data);
        }
        $this->_coreRegistry->register('ksolves_faqgroup_Post', $model);

        return $resultPage;
    }
}
