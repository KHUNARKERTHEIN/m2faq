<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Adminhtml\Post;

/**
* class Save
* Here Post is for FAQ
*/
class Save extends \Ksolves\FAQ\Controller\Adminhtml\Faq
{

    /**
    * Method to save faq
    */
    public function execute()
    {
        try {

         
            $data=$this->getRequest()->getPostValue();
            $data['faqgroup_id'] = implode(',', array_values($data['faqgroup_id']));

            $data['image'] = (isset($data['image']) && !empty($data['image'])) ? $data['image'][0]['name'] : null;
            unset($data['form_key']);
            $model = $this->_objectManager->create('Ksolves\FAQ\Model\Post');
            $model->setData($data);

            $session = $this->_objectManager->get('Magento\Backend\Model\Session');
            $session->setPageData($model->getData());
            $model->save();
            $this->messageManager->addSuccess(__('You saved the item.'));
            $session->setPageData(false);

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('ksolves_faq/*/edit', ['id' => $model->getId()]);
                return;
            }
            $this->_redirect('ksolves_faq/*/');
            return;

        } catch (\Exception $e) {
            $this->messageManager->addError(__('FAQ, Url Key and Sort Order are of unique type can not be duplicate.'));
            $this->_redirect('ksolves_faq/*/');
            return;
        }

    }
}
