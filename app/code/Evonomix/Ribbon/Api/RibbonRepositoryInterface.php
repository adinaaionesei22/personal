<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Repository Interface
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Api;

use Evonomix\Ribbon\Api\Data\RibbonInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface RibbonRepositoryInterface
{
    /**
     * Save ribbon
     *
     * @param RibbonInterface $ribbon
     * @return RibbonInterface
     * @throws CouldNotSaveException
     */
    public function save(RibbonInterface $ribbon): RibbonInterface;

    /**
     * Get ribbon by ID
     *
     * @param int $ribbonId
     * @return RibbonInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $ribbonId): RibbonInterface;

    /**
     * Delete ribbon
     *
     * @param RibbonInterface $ribbon
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(RibbonInterface $ribbon): bool;

    /**
     * Delete ribbon by ID
     *
     * @param int $ribbonId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $ribbonId): bool;
}

