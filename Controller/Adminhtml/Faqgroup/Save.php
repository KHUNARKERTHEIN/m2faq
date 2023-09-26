<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */
namespace Ksolves\FAQ\Controller\Adminhtml\Faqgroup;

/**
* class Save
*/
class Save extends \Ksolves\FAQ\Controller\Adminhtml\Faq
{
    /**
    * Method to save FaqGroup
    */
    public function execute()
    {
        try {

            $data=$this->getRequest()->getPostValue();
            unset($data['form_key']);
            $model = $this->_objectManager->create('Ksolves\FAQ\Model\Faq');
            $model->setData($data);
            $session = $this->_objectManager->get('Magento\Backend\Model\Session');
            $session->setPageData($model->getData());
            $model->save();
            $this->messageManager->addSuccess(__('You saved the item.'));
            $session->setPageData(false);
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('ksolves_faq/Faqgroup/edit', ['id' => $model->getId()]);
                return;
            }
            $this->_redirect('ksolves_faq/Faqgroup/');
            return;
        } catch(\Exception $e) {
            $this->messageManager->addError(__('Faq Group and Group Code are of unique type can not be duplicate.'));
            $this->_redirect('ksolves_faq/Faqgroup/');
            return;
        }   

    }
}
