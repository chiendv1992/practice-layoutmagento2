<?php 
namespace OpenTechiz\Blog\Api\Data;

interface CommentInterface
{
	
    const COMMENT_ID                  = 'comment_id';
    const CONTENT                  = 'content';
    const AUTHOR                    = 'author';
    const POST_ID                  = 'post_id';
    const CREATION_TIME            = 'creation_time';
    const IS_ACTIVE					= 'is_active';

	function getID();

	function getContent();

	function getAuthor();

	function getPostID();

	function getCreationTime();

	function isActive();

	function setID($id);

	function setContent($content);

	function setAuthor($author);

	function setPostID($postID);

	function setCreationTime($creatTime);

	function setIsActive($isactive);

}