<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
use Magento\Framework\DataObject\IdentityInterface;
class CommentList extends \Magento\Framework\View\Element\Template implements IdentityInterface
{
    protected $_commentCollectionFactory;

	protected $_request;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory,
		\Magento\Framework\App\RequestInterface $request,
		array $data = []
    	)
	{
		$this->_commentCollectionFactory = $commentCollectionFactory;
		$this->_request = $request;
		parent::__construct($context, $data);
	}

	public function getPostID()
	{
	    return $this->_request->getParam('post_id', false);
	}

	public function getComments()
	{
        $post_id = $this->getPostId();
        if(!$this->hasData("cmt")) {
            $comments = $this->_commentCollectionFactory
                ->create()
                ->addFilter('post_id', $post_id)
                ->addFieldToFilter('is_active', 1)
                ->addOrder(
                        CommentInterface::CREATION_TIME,
                        CommentCollection::SORT_ORDER_DESC
                    );
			$this->setData("cmt",$comments);
		}
		return $this->getData("cmt");
	}

    public function getTime()
    {

            $com = $this->_commentCollectionFactory
                ->create();

            print_r($com);
    }
    public function getIdentities()
    {
        $identities = [];
        foreach ($this->getComments() as $comment) {
            $identities = array_merge($identities, $comment->getIdentities());
        }
        $identities[] = \OpenTechiz\Blog\Model\Comment::CACHE_COMMENT_POST_TAG.'_'.$this->getPostID();
        return $identities;
    }

} 