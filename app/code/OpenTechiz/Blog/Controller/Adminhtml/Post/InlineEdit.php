<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\JsonFactory;
use OpenTechiz\Blog\Model\PostFactory;
class InlineIndex extends \Magento\Backend\App\Action
{

    protected $jonFactory;
    protected $banerFactory;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PostFactory $banerFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->banerFactory = $banerFactory;
    }

    public function execute()
    {

        // Init result Json
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        // Get POST data
        $postItems = $this->getRequest()->getParam('items', []);
        // Check request
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        // Save data to database
        foreach (array_keys($postItems) as $postId) {
            try {
                $post = $this->bannerFactory->create();
                $post->load($postId);
                $post->setData($postItems[(string)$postId]);
                $post->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong while saving the image.');
                $error = true;
            }
        }
        // Return result Json
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }


}