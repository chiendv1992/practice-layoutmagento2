<?php
namespace OpenTechiz\Blog\Api\Data;


interface PostInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POST_ID       = 'post_id';
    const URL_KEY       = 'url_key';
    const TITLE         = 'title';
    const CONTENT       = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get URL Key
     *
     * @return string
     */
    public function getUrlKey();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    public function getCreationTime();


    public function getUpdateTime();


    public function isActive();


    public function setId($id);


    public function setUrlKey($url_key);


    public function getUrl();


    public function setTitle($title);

    public function setContent($content);


    public function setCreationTime($creationTime);


    public function setUpdateTime($updateTime);


    public function setIsActive($isActive);
}
