<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action;
class Edit extends \Magento\Backend\App\Action
{
  
    protected $_coreRegistry = null;
 
    protected $resultPageFactory;
   
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::save_comment');
    }
   
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('OpenTechiz_Blog::comment')
            ->addBreadcrumb(__('Blog'), __('Blog'))
            ->addBreadcrumb(__('Manage Blog Comments'), __('Manage Blog Comments'));
        return $resultPage;
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('comment_id');
        $model = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This comment no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('blog_comment', $model);
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Blog Comment') : __('New Blog Comment'),
            $id ? __('Edit Blog Comment') : __('New Blog Comment')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Comments'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Blog Comment'));
        return $resultPage;
    }
}