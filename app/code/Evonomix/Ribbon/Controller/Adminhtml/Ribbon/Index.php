<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Admin Index Controller
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Controller\Adminhtml\Ribbon;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'Evonomix_Ribbon::manage';

    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $resultPageFactory;
    }

    /**
     * Execute action
     *
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Evonomix_Ribbon::manage');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Ribbons'));
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

