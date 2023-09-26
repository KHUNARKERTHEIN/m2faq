<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Adminhtml\Post;

/**
* class Edit
* Here Post is for FAQ
*/
class Edit extends \Ksolves\FAQ\Controller\Adminhtml\Faq
{

    /**
    * FAQ  action
    * @return \Magento\Framework\View\Result\$resultPageFactory
    */
    public function execute()
    {
        $id = $this->getRequest()->getParam('faq_id');
        $model = $this->_objectManager->create('Ksolves\FAQ\Model\Post');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $this->_redirect('ksolves_faq/*');
                return;
            }
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
          $this->_coreRegistry->register('ksolves_faq_post', $model);
          $resultPage = $this->resultPageFactory->create();
          $resultPage->getConfig()->getTitle()->prepend((__('Update FAQ')));
          return $resultPage;
    }
}
