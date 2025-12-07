<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Frontend Block
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Block;

use Evonomix\Ribbon\Model\ResourceModel\Ribbon\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Ribbon extends Template
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get active ribbons for current page
     *
     * @return array
     */
    public function getActiveRibbons(): array
    {
        $isHomepage = $this->isHomepage();

        $collection = $this->collectionFactory->create();
        $collection->addActiveFilter();
        $collection->addDateRangeFilter();

        $ribbons = [];
        foreach ($collection as $ribbon) {
            if ($ribbon->shouldDisplayOnPage($isHomepage)) {
                $ribbons[] = $ribbon;
            }
        }

        return $ribbons;
    }

    /**
     * Check if current page is homepage
     *
     * @return bool
     */
    public function isHomepage(): bool
    {
        $request = $this->getRequest();
        $moduleName = $request->getModuleName();
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();

        // Check if it's the CMS homepage
        if ($moduleName === 'cms' && $controllerName === 'index' && $actionName === 'index') {
            return true;
        }

        return false;
    }
}

