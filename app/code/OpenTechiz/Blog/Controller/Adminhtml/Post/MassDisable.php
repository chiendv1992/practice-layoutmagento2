<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassDisable  extends \Magento\Backend\App\Action
{

    protected $filter;

    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $item) {
            $item->setIsActive(false);
            $item->save();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collection->getSize()));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}