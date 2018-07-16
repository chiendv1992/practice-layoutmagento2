<?php
namespace OpenTechiz\Blog\Model\ResourceModel;

class Notification extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('opentechiz_notification_approve', 'noti_id');
    }
}