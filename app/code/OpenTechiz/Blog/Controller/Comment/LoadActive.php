<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
class LoadActive extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;
    protected $_commentFactory;
    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentFactory,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_commentFactory = $commentFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $post = (array) $this->getRequest()->getPostValue();
        $post_id = $post['post_id'];
        $jsonResultResponse = $this->_resultJsonFactory->create();
        $comments = $this->_commentFactory
            ->create()
            ->addFieldToFilter('post_id', $post_id)
            ->addFieldToFilter('is_active', 1)
            ->addOrder(
                CommentInterface::CREATION_TIME,
                CommentCollection::SORT_ORDER_DESC
            )->toArray();
        if($comments['totalRecords']==0) return false;
        $jsonResultResponse->setData($comments);
        return $jsonResultResponse;
    }
}