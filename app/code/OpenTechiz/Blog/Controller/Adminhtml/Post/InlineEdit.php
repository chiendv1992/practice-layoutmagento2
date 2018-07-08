<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\JsonFactory;
use OpenTechiz\Blog\Model\PostFactory;


class InlineEdit extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'OpenTechiz_Blog::save';

    protected $dataProcessor;

    protected $postRepository;

    protected $jsonFactory;

    public function __construct(
        Context $context,
        PostRepository $postRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {

        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $postId) {
            /** @var \OpenTechiz\Blog\Model\Post $post */
            $post = $this->postRepository->getById($postId);
            try {
                $post = $this->postFactory->create();
                $post->load($postId);
                $post->setData($postItems[(string)$postId]);
                $post->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPostId($post, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPostId($post, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPostId(
                    $post,
                    __('Something went wrong while saving the post.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function validatePost(array $postData, \OpenTechiz\Blog\Model\Post $post, &$error, array &$messages)
    {
        if (!($this->dataProcessor->validate($postData) && $this->dataProcessor->validateRequireEntry($postData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPostId($post, $error->getText());
            }
        }
    }

    protected function getErrorWithPostId(PostInterface $post, $errorText)
    {
        return '[Post ID: ' . $post->getId() . '] ' . $errorText;
    }

}
