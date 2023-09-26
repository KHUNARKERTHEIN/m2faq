<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */


namespace KSOLVES\FAQ\Model\Source;

class Myvalues implements \Magento\Framework\Option\ArrayInterface
{
  
    private $_objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    /**
    * @return  array of options for multiselect dropdown in add faq
    */
    public function toOptionArray()
    {

        $model=$this->_objectManager->create('Ksolves\FAQ\Model\Faq');
        $datacollection=$model->getCollection();
        $data=$datacollection->getData();
        $options = array();
        foreach ($data as $code) {
            $options[] = array('value' => $code['faqgroup_id'], 'label' => $code['group_code']);
        }

        return $options;
    }
}
