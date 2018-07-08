<?php

namespace OpenTechiz\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;


interface PostRepositoryInterface
{

    public function save(\OpenTechiz\Blog\Api\Data\PostInterface $post);

    public function getById($postId);

    public function getList(SearchCriteriaInterface $searchCriteria);

    public function delete(\OpenTechiz\Blog\Api\Data\PostInterface $post);

    public function deleteById($postId);
}
