<?php

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'OpenTechiz_Blog::save';

    protected $_coreRegistry;

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


    protected function _initAction()
    {

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('OpenTechiz_Blog::blog_post');
        return $resultPage;
    }

    public function execute()
    {

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('post_id');

        $model = $this->_objectManager->create('OpenTechiz\Blog\Model\Post');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Post no longer exists.'));
                //chuyen huong nguoi dung bang cach tai lai trang moi
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('post', $model);

        // 5. Build edit form
        $resultPage = $this->_initAction();

        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Post'));

        return $resultPage;
    }
}
