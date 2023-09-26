<?php

/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Block\Adminhtml\Faq\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
* class SaveAndContinueButton
*/
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue '),
            'class' => 'save',
            'data_attribute' => [
            'mage-init' => [
            'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 80,
        ];
    }
}
