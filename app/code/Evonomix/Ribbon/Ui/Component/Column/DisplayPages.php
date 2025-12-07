<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Display Pages Column Renderer
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Ui\Component\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Evonomix\Ribbon\Model\Ribbon;

class DisplayPages extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$this->getData('name')])) {
                    $value = $item[$this->getData('name')];
                    if ($value == Ribbon::DISPLAY_HOMEPAGE_ONLY) {
                        $item[$this->getData('name')] = __('Homepage');
                    } elseif ($value == Ribbon::DISPLAY_ALL_PAGES) {
                        $item[$this->getData('name')] = __('All Pages');
                    }
                }
            }
        }

        return $dataSource;
    }
}

