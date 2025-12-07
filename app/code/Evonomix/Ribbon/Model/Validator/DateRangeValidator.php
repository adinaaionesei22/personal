<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Date Range Validator
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Model\Validator;

use Evonomix\Ribbon\Model\Ribbon;
use Evonomix\Ribbon\Model\ResourceModel\Ribbon\CollectionFactory;

class DateRangeValidator
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Validate that date range doesn't overlap with existing ribbons
     *
     * @param Ribbon $ribbon
     * @param array $data
     * @return bool
     */
    public function validate(Ribbon $ribbon, array $data): bool
    {
        if (!isset($data['start_date']) || !isset($data['end_date'])) {
            return false;
        }

        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);

        // Check if end date is after start date
        if ($endDate < $startDate) {
            return false;
        }

        // Get all other ribbons
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', 1);

        if ($ribbon->getId()) {
            $collection->addFieldToFilter('ribbon_id', ['neq' => $ribbon->getId()]);
        }

        // Check for overlaps
        foreach ($collection as $existingRibbon) {
            $existingStart = new \DateTime($existingRibbon->getStartDate());
            $existingEnd = new \DateTime($existingRibbon->getEndDate());

            // Check if date ranges overlap
            if ($this->rangesOverlap($startDate, $endDate, $existingStart, $existingEnd)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if two date ranges overlap
     *
     * @param \DateTime $start1
     * @param \DateTime $end1
     * @param \DateTime $start2
     * @param \DateTime $end2
     * @return bool
     */
    protected function rangesOverlap(
        \DateTime $start1,
        \DateTime $end1,
        \DateTime $start2,
        \DateTime $end2
    ): bool {
        // Two ranges overlap if: start1 <= end2 && start2 <= end1
        return $start1 <= $end2 && $start2 <= $end1;
    }
}

