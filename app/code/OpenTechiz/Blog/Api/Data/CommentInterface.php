<?php
namespace OpenTechiz\Blog\Api\Data;


interface CommentInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const COMMENT_ID       = 'comment_id';
    const CONTENT       = 'content';
    const AUTHOR         = 'author';
    const POST_ID       = 'post_id';
    const CREATION_TIME = 'creation_time';
    const IS_ACTIVE	= 'is_active';
    const EMAIL = 'email';
    const USER_ID = 'user_id';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    public function getEmail();

    public function getContent();

    public function getAuthor();

    public function getPostId();

    public function getCreationTime();

    public function getUserID();

    public function isActive();

    public function setId($id);

    public function setContent($content);

    public function setAuthor($author);

    public function setPostId($post_id);

    public function setCreationTime($creationTime);

    public function setIsActive($isActive);

    public function setEmail($email);

    public function setUserID($userID);

}
