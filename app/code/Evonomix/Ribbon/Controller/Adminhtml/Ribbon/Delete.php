<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Admin Delete Controller
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Controller\Adminhtml\Ribbon;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Evonomix\Ribbon\Api\RibbonRepositoryInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Evonomix_Ribbon::manage';

    /**
     * @var RibbonRepositoryInterface
     */
    protected RibbonRepositoryInterface $ribbonRepository;

    /**
     * @param Context $context
     * @param RibbonRepositoryInterface $ribbonRepository
     */
    public function __construct(
        Context $context,
        RibbonRepositoryInterface $ribbonRepository
    ) {
        parent::__construct($context);
        $this->ribbonRepository = $ribbonRepository;
    }

    /**
     * Execute action
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            try {
                $this->ribbonRepository->deleteById((int)$id);
                $this->messageManager->addSuccessMessage(__('You deleted the ribbon.'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This ribbon no longer exists.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
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

