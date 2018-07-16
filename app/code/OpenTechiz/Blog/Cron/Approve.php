<?php
namespace OpenTechiz\Blog\Cron;

use \Psr\Log\LoggerInterface;
class Approve {

    protected $_commentCollection;
    protected $_userCollection;
    protected $_sendEmail;

    public function __construct(
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollection,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollection,
        \OpenTechiz\Blog\Helper\Email $sendEmail,
        LoggerInterface $logger
    )
    {
        $this->_commentCollection = $commentCollection;
        $this->_userCollection = $userCollection;
        $this->_sendEmail = $sendEmail;
        $this->logger = $logger;
    }
    public function execute() {

        $to = date("Y-m-d h:i:s"); // current date
        $from = strtotime('-1 day', strtotime($to));
        $from = date('Y-m-d h:i:s', $from); // 1 day before
        $comments = $this->_commentCollection
            ->create()
            ->addFieldToFilter('is_active', 0)
            ->addFieldToFilter('creation_time', ["lteq" => $from]);
        $commentCount = $comments->count();
        // get admins list
        $admins = $this->_userCollection->create();
        if($commentCount>0 && $admins->count()>0)
        {
            $email = 'sondt16101993@gmail.com';
            $name = 'Admin';
            $this->_sendEmail->remindEmail($commentCount, $email, $name);
        }
        $this->logger->info('Cron Works');
    }
}