<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Display Pages Config
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;
use Evonomix\Ribbon\Model\Ribbon;

class DisplayPages implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => Ribbon::DISPLAY_ALL_PAGES, 'label' => __('All Pages')],
            ['value' => Ribbon::DISPLAY_HOMEPAGE_ONLY, 'label' => __('Homepage')]
        ];
    }
}

