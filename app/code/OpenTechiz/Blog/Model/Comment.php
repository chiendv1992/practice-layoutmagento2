<?php
namespace OpenTechiz\Blog\Model;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Comment extends \Magento\Framework\Model\AbstractModel implements CommentInterface,IdentityInterface
{
	const CACHE_TAG='opentechiz_blog_comment';

	function _construct()
	{
		$this->_init('OpenTechiz\Blog\Model\ResourceModel\Comment');
	}
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    function getID(){
        return $this->getData(self::COMMENT_ID);
    }

    function getContent(){
        return $this->getData(self::CONTENT);
    }

    function getPostID(){
        return $this->getData(self::POST_ID);
    }

    function getAuthor(){
        return $this->getData(self::AUTHOR);
    }

    function getCreationTime(){
        return $this->getData(self::CREATION_TIME);
    }

    function setID($id){
        $this->setData(self::COMMENT_ID,$id);
        return $this;
    }

    function setAuthor($author){
        $this->setData(self::AUTHOR,$author);
        return $this;
    }

    function setContent($content){
        $this->setData(self::CONTENT,$content);
        return $this;
    }

    function setPostID($postId){
        $this->setData(self::POST_ID,$postId);
        return $this;
    }

    function setCreationTime($creatTime){
        $this->setData(self::CREATION_TIME,$creatTime);
        return $this;
    }
}