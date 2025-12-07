<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Resource Model
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Ribbon extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('evonomix_ribbon', 'ribbon_id');
    }
}

