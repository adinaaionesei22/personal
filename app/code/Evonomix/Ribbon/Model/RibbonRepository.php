<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Repository
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Model;

use Evonomix\Ribbon\Api\Data\RibbonInterface;
use Evonomix\Ribbon\Api\RibbonRepositoryInterface;
use Evonomix\Ribbon\Model\ResourceModel\Ribbon as RibbonResourceModel;
use Evonomix\Ribbon\Model\ResourceModel\Ribbon\CollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class RibbonRepository implements RibbonRepositoryInterface
{
    /**
     * @var RibbonResourceModel
     */
    protected RibbonResourceModel $resourceModel;

    /**
     * @var RibbonFactory
     */
    protected RibbonFactory $ribbonFactory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param RibbonResourceModel $resourceModel
     * @param RibbonFactory $ribbonFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        RibbonResourceModel $resourceModel,
        RibbonFactory $ribbonFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->ribbonFactory = $ribbonFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Save ribbon
     *
     * @param RibbonInterface $ribbon
     * @return RibbonInterface
     * @throws CouldNotSaveException
     */
    public function save(RibbonInterface $ribbon): RibbonInterface
    {
        try {
            $this->resourceModel->save($ribbon);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the ribbon: %1', $exception->getMessage()),
                $exception
            );
        }
        return $ribbon;
    }

    /**
     * Get ribbon by ID
     *
     * @param int $ribbonId
     * @return RibbonInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $ribbonId): RibbonInterface
    {
        $ribbon = $this->ribbonFactory->create();
        $this->resourceModel->load($ribbon, $ribbonId);
        if (!$ribbon->getId()) {
            throw new NoSuchEntityException(
                __('Ribbon with id "%1" does not exist.', $ribbonId)
            );
        }
        return $ribbon;
    }

    /**
     * Delete ribbon
     *
     * @param RibbonInterface $ribbon
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(RibbonInterface $ribbon): bool
    {
        try {
            $this->resourceModel->delete($ribbon);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the ribbon: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * Delete ribbon by ID
     *
     * @param int $ribbonId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $ribbonId): bool
    {
        return $this->delete($this->getById($ribbonId));
    }
}

