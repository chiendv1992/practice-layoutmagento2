<?php 
namespace OpenTechiz\Blog\Api\Data;

interface PostInterface
{
    const POST_ID                  = 'post_id';
    const URL_KEY                  = 'url_key';
    const TITLE                    = 'title';
    const CONTENT                  = 'content';
    const CREATION_TIME            = 'creation_time';
    const UPDATE_TIME              = 'update_time';
    const IS_ACTIVE                = 'is_active';
 
	function getID();

	function getUrlKey();

	function getTitle();

	function getContent();

	function getUserID();

	function getPhoto();

	function getCreationTime();

	function getUpdateTime();

	function isActive();

	function setID($id);

	function setUrlKey($urlKey);

	function setTitle($title);

	function setContent($content);

	function setUserID($userId);

	function setPhoto($photoUrl);

	function setCreationTime($creatTime);

	function setUpdateTime($updateTime);

	function setIsActive($isactive);
}