<?php
namespace Tsum\CashFlow\Controller\Adminhtml\Incomes;

use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;
use Tsum\CashFlow\Model\ResourceModel\Incomes as IncomesResource;
use Tsum\CashFlow\Model\Incomes;
use Tsum\CashFlow\Model\IncomesFactory;

/**
 * Edit CMS page action.
 */
class EditIn extends Action implements HttpGetActionInterface
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Tsum_CashFlow::incomes';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var IncomesResource
     */
    private $incomesResource;

    /**
     * @var IncomesFactory
     */
    private $incomesFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        IncomesResource $incomesResource,
        DataPersistorInterface $dataPersistor,
        IncomesFactory $incomesFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->incomesResource = $incomesResource;
        $this->incomesFactory = $incomesFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     *
     * @return Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Tsum_CashFlow::incomes')
            ->addBreadcrumb(__('In'), __('In'))
            ->addBreadcrumb(__('Manage Incomes'), __('Manage Incomes'));
        return $resultPage;
    }

    /**
     * @return Page|Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $this->dataPersistor->set('tsum_incomes_in', 1);
        $id = $this->getRequest()->getParam(Incomes::ENTITY_ID);
        $model = $this->incomesFactory->create();

        if ($id) {
            $this->incomesResource->load($model, $id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This income no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Income (In)') : __('New In'),
            $id ? __('Edit Income (In)') : __('New In')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('In'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New In'));

        return $resultPage;
    }
}