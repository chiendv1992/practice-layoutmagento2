<?php

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'OpenTechiz_Blog::save';

    protected $resultForwardFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
