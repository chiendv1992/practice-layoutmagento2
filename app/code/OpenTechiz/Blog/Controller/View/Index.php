<?php
namespace OpenTechiz\Blog\Controller\View;

use \Magento\Framework\App\Action\Action;

class Index extends Action
{
    /** @var \Magento\Framework\Controller\Result\ForwardFactory */
    protected $resultForwardFactory;
    public $timezone;

    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
                                \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->timezone = $timezone;
        parent::__construct($context);
    }

    
    public function execute()
    {
   
        $post_id = $this->getRequest()->getParam('post_id', $this->getRequest()->getParam('id', false));
        
        $post_helper = $this->_objectManager->get('OpenTechiz\Blog\Helper\Post');
        $result_page = $post_helper->prepareResultPost($this, $post_id);
        if (!$result_page) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $result_page;
    }
}
