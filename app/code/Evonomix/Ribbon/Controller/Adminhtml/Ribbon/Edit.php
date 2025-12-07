<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Admin Edit Controller
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Controller\Adminhtml\Ribbon;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Evonomix\Ribbon\Api\RibbonRepositoryInterface;

class Edit extends Action
{
    public const ADMIN_RESOURCE = 'Evonomix_Ribbon::manage';

    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;

    /**
     * @var RibbonRepositoryInterface
     */
    protected RibbonRepositoryInterface $ribbonRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param RibbonRepositoryInterface $ribbonRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        RibbonRepositoryInterface $ribbonRepository
    ) {
        parent::__construct($context);
        $this->pageFactory = $resultPageFactory;
        $this->ribbonRepository = $ribbonRepository;
    }

    /**
     * Execute action
     *
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Evonomix_Ribbon::manage');

        if ($id) {
            try {
                $this->ribbonRepository->getById((int)$id);
                $resultPage->getConfig()->getTitle()->prepend(__('Edit Ribbon'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This ribbon no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Ribbon'));
        }

        return $resultPage;
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

