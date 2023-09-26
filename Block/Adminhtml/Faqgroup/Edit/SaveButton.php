<?php

/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */
namespace Ksolves\FAQ\Block\Adminhtml\Faqgroup\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
* class SaveButton
*/
class SaveButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save FAQ Group'),
            'class' => 'save primary',
            'data_attribute' => [
            'mage-init' => ['button' => ['event' => 'save']],
            'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
