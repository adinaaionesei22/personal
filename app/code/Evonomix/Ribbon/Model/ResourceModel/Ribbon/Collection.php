<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Collection
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Model\ResourceModel\Ribbon;

use Evonomix\Ribbon\Model\Ribbon;
use Evonomix\Ribbon\Model\ResourceModel\Ribbon as RibbonResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Ribbon::class, RibbonResourceModel::class);
    }

    /**
     * Filter by active status
     *
     * @return $this
     */
    public function addActiveFilter(): self
    {
        return $this->addFieldToFilter('is_active', 1);
    }

    /**
     * Filter by current date range
     *
     * @return $this
     */
    public function addDateRangeFilter(): self
    {
        $now = date('Y-m-d H:i:s');
        $this->addFieldToFilter('start_date', ['lteq' => $now]);
        $this->addFieldToFilter('end_date', ['gteq' => $now]);
        return $this;
    }
}

