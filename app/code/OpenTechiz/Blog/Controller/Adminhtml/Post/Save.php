<?php

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Model\Post;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'OpenTechiz_Blog::save';

    protected $dataProcessor;

    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            // Optimize data
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Post::STATUS_ENABLED;
            }
            if (empty($data['post_id'])) {
                $data['post_id'] = null;
            }
            // Init model and load by post_id if exists
            $model = $this->_objectManager->create('OpenTechiz\Blog\Model\Post');
            $post_id = $this->getRequest()->getParam('post_id');
            if ($post_id) {
                $model->load($post_id);
            }
            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit Post if has error
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getpost_id(), '_current' => true]);
            }
            // Update model
            $model->setData($data);
            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the post.'));
                $this->dataPersistor->clear('blog_post');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getpost_id(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the image.'));
            }
            $this->dataPersistor->set('blog_post', $data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        // Redirect to List Post
        return $resultRedirect->setPath('*/*/');
    }
}
