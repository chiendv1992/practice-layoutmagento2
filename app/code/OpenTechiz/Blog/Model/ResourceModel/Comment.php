<?php
namespace OpenTechiz\Blog\Model\ResourceModel;

/**
 * Blog post mysql resource
 */
class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('opentechiz_post_comment', 'comment_id');
    }

}
