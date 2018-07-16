<?php namespace OpenTechiz\Blog\Model;

use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Comment extends \Magento\Framework\Model\AbstractModel implements CommentInterface, IdentityInterface
{

   
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;
    const STATUS_PENDING = 0;
    
    const CACHE_TAG = 'opentechiz_post_comment';
    const CACHE_COMMENT_POST_TAG = "opentechiz_blog_comment_post";
   
    protected $_cacheTag = 'opentechiz_post_comment';

    
    protected $_eventPrefix = 'opentechiz_post_comment';

    
    protected $_urlBuilder;

    
    function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [])
    {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    
    protected function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\ResourceModel\Comment');
    }

    
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled'), self::STATUS_PENDING => __('Pending')];
    }
    
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    

    public function getId()
    {
        return $this->getData(self::COMMENT_ID);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }


    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    
    public function getAuthor()
    {
        return $this->getData(self::AUTHOR);
    }

    function getUrl(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $urlBuilder=$objectManager->get("Magento\Framework\UrlInterface");
        return $urlBuilder->getUrl("blog/".$this->getUrlKey());
    }

    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

  
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }



    public function setId($id)
    {
        return $this->setData(self::COMMENT_ID, $id);
    }


    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }

    public function setPostId($post_id)
    {
        return $this->setData(self::POST_ID, $post_id);
    }

    public function setCreationTime($creation_time)
    {
        return $this->setData(self::CREATION_TIME, $creation_time);
    }

    function isActive(){
        return $this->getData(self::IS_ACTIVE);
    }

    function setIsActive($isActive){
        $this->setData(self::IS_ACTIVE,$isActive);
        return $this;
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    function setUserID($userID){
        $this->setData(self::USER_ID,$userID);
        return $this;
    }

    function getUserID(){
        return $this->getData(self::USER_ID);
    }

}
