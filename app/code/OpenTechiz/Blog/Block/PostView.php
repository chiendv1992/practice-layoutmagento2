<?php
namespace OpenTechiz\Blog\Block;

class PostView extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{
    protected $_commentCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \OpenTechiz\Blog\Model\Post $post,
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollection,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
        $this->_commentCollection = $commentCollection;
    }


    public function getPost()
    {
       
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                /** @var \OpenTechiz\Blog\Model\Post $page */
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = $this->getPost()->getIdentities();
        $comments = $this->_commentCollection
            ->create()
            ->addFieldToFilter('is_active', '1');
        foreach ($comments as $comment) {
            $identities = array_merge($identities,
                [\OpenTechiz\Blog\Model\Comment::CACHE_COMMENT_POST_TAG."_".$comment->getID()]);
        }
        return ($identities);
    }

}
