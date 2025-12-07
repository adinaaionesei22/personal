<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon UI Data Provider
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Ui;

use Evonomix\Ribbon\Api\RibbonRepositoryInterface;
use Evonomix\Ribbon\Model\ResourceModel\Ribbon\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var RibbonRepositoryInterface
     */
    protected RibbonRepositoryInterface $ribbonRepository;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RibbonRepositoryInterface $ribbonRepository
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RibbonRepositoryInterface $ribbonRepository,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->ribbonRepository = $ribbonRepository;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $ribbonId = $this->request->getParam($this->requestFieldName);

        if ($ribbonId) {
            try {
                $ribbon = $this->ribbonRepository->getById((int)$ribbonId);
                if ($ribbon && $ribbon->getId()) {
                    $this->loadedData[$ribbon->getId()] = [
                        'id' => $ribbon->getId(),
                        'ribbon_id' => $ribbon->getId(),
                        'title' => $ribbon->getTitle() ?? '',
                        'description' => $ribbon->getDescription() ?? '',
                        'link' => $ribbon->getLink() ?? '',
                        'band_color' => $ribbon->getBandColor() ?? '#000000',
                        'start_date' => $ribbon->getStartDate() ?? '',
                        'end_date' => $ribbon->getEndDate() ?? '',
                        'display_pages' => $ribbon->getDisplayPages() ?? 0,
                        'is_active' => $ribbon->getIsActive() ? '1' : '0',
                    ];
                }
            } catch (NoSuchEntityException|\Exception $e) {
                $this->loadedData = [];
            }

            return $this->loadedData;
        }

        return [];
    }
}
