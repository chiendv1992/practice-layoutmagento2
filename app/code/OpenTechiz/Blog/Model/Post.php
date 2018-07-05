<?php
namespace OpenTechiz\Blog\Model;
use OpenTechiz\Blog\Api\Data\PostInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface,IdentityInterface
{
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED =0;
	const CACHE_TAG='opentechiz_blog_post';

	function _construct()
	{
		$this->_init('OpenTechiz\Blog\Model\ResourceModel\Post');
	}
	
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
	
    public function checkUrlKey($url_key)
    {
        return $this->_getResource()->checkUrlKey($url_key);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    function getID(){
        return $this->getData(self::POST_ID);
    }

    function getUrlKey(){
        return $this->getData(self::URL_KEY);
    }

    function getTitle(){
        return $this->getData(self::TITLE);
    }

    function getUrl(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $urlBuilder=$objectManager->get("Magento\Framework\UrlInterface");
        return $urlBuilder->getUrl("blog/".$this->getUrlKey());
    }

    function getContent(){
        return $this->getData(self::CONTENT);
    }

    function getUserID(){
        return $this->getData(self::USER_ID);
    }

    function getPhoto(){
        return $this->getData(self::PHOTO);
    }

    function getCreationTime(){
        return $this->getData(self::CREATION_TIME);
    }

    function getUpdateTime(){
        return $this->getData(self::UPDATE_TIME);
    }

    function isActive(){
        return $this->getData(self::IS_ACTIVE);
    }

    function setID($id){
        $this->setData(self::POST_ID,$id);
        return $this;
    }

    function setUrlKey($urlKey){
        $this->setData(self::URL_KEY,$urlKey);
        return $this;
    }

    function setTitle($title){
        $this->setData(self::TITLE,$title);
        return $this;
    }

    function setContent($content){
        $this->setData(self::CONTENT,$content);
        return $this;
    }

    function setUserID($userId){
        $this->setData(self::USER_ID,$userId);
        return $this;
    }

    function setPhoto($photoUrl){
        $this->setData(self::PHOTO,$photoUrl);
        return $this;
    }

    function setCreationTime($creatTime){
        $this->setData(self::CREATION_TIME,$creatTime);
        return $this;
    }

    function setUpdateTime($updateTime){
        $this->setData(self::UPDATE_TIME,$updateTime);
        return $this;
    }

    function setIsActive($isActive){
        $this->setData(self::IS_ACTIVE,$isActive);
        return $this;
    }
}