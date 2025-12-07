<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Admin Save Controller
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Controller\Adminhtml\Ribbon;

use Evonomix\Ribbon\Api\RibbonRepositoryInterface;
use Evonomix\Ribbon\Model\RibbonFactory;
use Evonomix\Ribbon\Model\Validator\DateRangeValidator;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'Evonomix_Ribbon::manage';

    /**
     * @var RibbonRepositoryInterface
     */
    protected RibbonRepositoryInterface $ribbonRepository;

    /**
     * @var RibbonFactory
     */
    protected RibbonFactory $ribbonFactory;

    /**
     * @var DateRangeValidator
     */
    protected DateRangeValidator $dateRangeValidator;

    /**
     * @param Context $context
     * @param RibbonRepositoryInterface $ribbonRepository
     * @param RibbonFactory $ribbonFactory
     * @param DateRangeValidator $dateRangeValidator
     */
    public function __construct(
        Context $context,
        RibbonRepositoryInterface $ribbonRepository,
        RibbonFactory $ribbonFactory,
        DateRangeValidator $dateRangeValidator
    ) {
        parent::__construct($context);
        $this->ribbonRepository = $ribbonRepository;
        $this->ribbonFactory = $ribbonFactory;
        $this->dateRangeValidator = $dateRangeValidator;
    }

    /**
     * Execute action
     *
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        $id = $this->getRequest()->getParam('ribbon_id');

        if ($id) {
            try {
                $ribbon = $this->ribbonRepository->getById((int)$id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This ribbon no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $ribbon = $this->ribbonFactory->create();
        }

        try {
            // Extract data from form structure (data array or direct)
            $formData = $data;
            if (isset($data['data']) && is_array($data['data'])) {
                $formData = $data['data'];
            }

            // Validate date range doesn't overlap with existing ribbons
            if (!$this->dateRangeValidator->validate($ribbon, $formData)) {
                $this->messageManager->addErrorMessage(
                    __('The date range overlaps with an existing ribbon. Please choose a different date range.')
                );
                if ($id) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
                } else {
                    return $resultRedirect->setPath('*/*/edit');
                }
            }

            // Set data
            $ribbon->setTitle($formData['title'] ?? '');
            $ribbon->setDescription($formData['description'] ?? '');
            $ribbon->setLink($formData['link'] ?? '');
            $ribbon->setBandColor($formData['band_color'] ?? '#000000');
            $ribbon->setStartDate($formData['start_date'] ?? '');
            $ribbon->setEndDate($formData['end_date'] ?? '');
            $ribbon->setDisplayPages(isset($formData['display_pages']) ? (int)$formData['display_pages'] : 0);

            $ribbon->setIsActive((int)$formData['is_active']);

            $this->ribbonRepository->save($ribbon);
            $this->messageManager->addSuccessMessage(__('You saved the ribbon.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($id) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            } else {
                return $resultRedirect->setPath('*/*/edit');
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check if user has access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
