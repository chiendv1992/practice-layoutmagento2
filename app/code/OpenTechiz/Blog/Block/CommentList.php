<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class CommentList extends \Magento\Framework\View\Element\Template
                  implements  \Magento\Framework\DataObject\IdentityInterface
{
	protected $_commentCollectionFactory;

	protected $_request;

	protected $_resultJsonFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
		\Magento\Framework\App\RequestInterface $request,
		array $data = []
	)
	{
		$this->_commentCollectionFactory = $commentCollectionFactory;
		$this->_resultJsonFactory = $resultJsonFactory;
		$this->_request = $request;
		parent::__construct($context, $data);
	}

	public function getPostID()
	{
		return $this->_request->getParam('post_id', false);
	}

	public function getComments()
	{
		$post_id = $this->getPostID();
		if(!$this->hasData("cmt")) {
			$comments = $this->_commentCollectionFactory
				->create()
				->addFilter('post_id', $post_id)
				->addOrder(
					CommentInterface::CREATION_TIME,
					CommentCollection::SORT_ORDER_DESC
				);
			$this->setData("cmt",$comments);
		}
		return $this->getData("cmt");
	}

    public function getIdentities()
    {
        $identities = [];
        foreach ($this->getComments() as $comment)
        {
            $identities = array_merge($identities,
                [\OpenTechiz\Blog\Model\Comment::CACHE_COMMENT_POST_TAG."_".$comment->getID()]);
        }
        $identities[] = \OpenTechiz\Blog\Model\Post::CACHE_TAG.'_'.$this->getPostID();
        return $identities;
    }

}