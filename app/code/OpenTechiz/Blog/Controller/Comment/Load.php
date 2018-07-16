<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class Load extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    protected $_commentFactory;
    protected $_customerSession;

    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_commentFactory = $commentFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        if(!$this->_customerSession->isLoggedIn()) return false;
        $post = (array) $this->getRequest()->getPostValue();
        $post_id = $post['post_id'];
        $user_id = $this->_customerSession->getCustomer()->getId();

        $jsonResultResponse = $this->_resultJsonFactory->create();
        $comments = $this->_commentFactory
            ->create()
            ->addFieldToFilter('post_id', $post_id)
            ->addFieldToFilter('is_active', 0)
            ->addFieldToFilter('user_id', $user_id)
            ->addOrder(
                CommentInterface::CREATION_TIME,
                CommentCollection::SORT_ORDER_DESC
            )->toArray();

        if($comments['totalRecords']==0) return false;
        $jsonResultResponse->setData($comments);
        return $jsonResultResponse;
    }
}