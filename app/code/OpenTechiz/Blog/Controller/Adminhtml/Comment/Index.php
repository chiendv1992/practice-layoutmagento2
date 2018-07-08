<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Backend\App\Action
{
  
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
   
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('OpenTechiz_Blog::comment');
        $resultPage->addBreadcrumb(__('Blog Comments'), __('Blog Comments'));
        $resultPage->addBreadcrumb(__('Manage Blog Comments'), __('Manage Blog Comments'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Comments'));
        return $resultPage;
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::comment');
    }
}