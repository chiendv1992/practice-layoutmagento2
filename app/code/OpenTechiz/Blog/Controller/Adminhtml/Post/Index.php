<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Backend\App\Action
{

    protected $resultPostFactory;
    public function __construct(
        Context $context,
        PageFactory $resultPostFactory
    ) {
        parent::__construct($context);
        $this->resultPostFactory = $resultPostFactory;
    }

    public function execute()
    {

        $resultPost = $this->resultPostFactory->create();
        $resultPost->setActiveMenu('OpenTechiz_Blog::post');
        $resultPost->addBreadcrumb(__('Blog Posts'), __('Blog Posts'));
        $resultPost->addBreadcrumb(__('Manage Blog Posts'), __('Manage Blog Posts'));
        $resultPost->getConfig()->getTitle()->prepend(__('Blog Posts'));
        return $resultPost;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::post');
    }
}