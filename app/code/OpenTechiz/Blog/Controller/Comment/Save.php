<?php

namespace OpenTechiz\Blog\Controller\Comment;

use OpenTechiz\Blog\Model\CommentFactory;
use OpenTechiz\Blog\Helper\Email;
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    protected $inlineTranslation;
    protected $_customerSession;

    public $helperEmail;
    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        CommentFactory $commentFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        Email $helperEmail
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->commentFactory = $commentFactory;
        $this->helperEmail = $helperEmail;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }
    public function execute()
    {

        $error = false;
        $message = '';
        $post = $this->getRequest()->getPostValue();
        if(!$post)
        {
            $error = true;
            $message = "Your submission is not valid. Please try again!";
        }
        //to avoid inline translation broking ajax response
        $this->inlineTranslation->suspend();
        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($post);

        //add validation data code here
        $customer = null;
        if($this->_customerSession->isLoggedIn())
        {
            $customer = $this->_customerSession->getCustomer();
            $post['author'] = $customer->getName();
            $post['email'] = $customer->getEmail();
            $post['user_id'] = $customer->getId();
            //var_dump($post);die();
        }
        else if(!\Zend_Validate::is(trim($post['author']), 'NotEmpty'))
        {
            // validate data
            $error = true;
            $message = "Name can not be empty!";
        }
        //var_dump($post);die();
        // save data to database
        $author   = $post['author'];
        $content    = $post['content'];
        $post_id = $post['post_id'];
        $email = $post['email'];
        $comment = $this->commentFactory->create();
        //$comment->load($post_id);
        $comment->setAuthor($author);
        $comment->setContent($content);
        $comment->setPostId($post_id);
        $comment->setEmail($email);
        if(isset($post['user_id'])){
            $comment->setUserID($post['user_id']);
        }
        $comment->save();
        //echo "dsfsd";
        //print_r($comment->getData());die();
        $create_time = date("Y-m-d h:i:s");
        $jsonResultResponse = $this->resultJsonFactory->create();
        if(!$error)
        {
            $jsonResultResponse->setData([
                'result' => 'success',
                'message' => 'Thank you for your submission. Our Admins will review and approve shortly',
                'comment'=> $comment->getData(),
                'time' => $create_time
            ]);
        } else {
            $jsonResultResponse->setData([
                'result' => 'error',
                'message' => $message
            ]);
        }

        $sender = [
            'name' => 'Demo',
            'email' => 'chiendv92@gmail.com'
        ];



        return $jsonResultResponse;
    }
}