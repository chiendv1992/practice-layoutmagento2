<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
class Save extends Action
{

    protected $_resultJsonFactory;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    public function execute()
    {
        $error = false;
        $message = '';
        $postData = (array) $this->getRequest()->getPostValue();
        if(!$postData)
        {
            $error = true;
            $message = "Your submission is not valid. Please try again!";
        }
        $this->_inlineTranslation->suspend();
        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($postData);
        // validate data
        if(!\Zend_Validate::is(trim($postData['author']), 'NotEmpty'))
        {
            $error = true;
            $message = "Name can not be empty!";
        }
        if(!\Zend_Validate::is(trim($postData['email']), 'NotEmpty'))
        {
            $error = true;
            $message = "Email can not be empty!";
        }
        $jsonResultResponse = $this->_resultJsonFactory->create();
        if(!$error)
        {
            // save data to database
            $author = $postData['author'];
            $email = $postData['email'];
            $content = $postData['content'];
            $post_id = $postData['post_id'];
            $comment = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
            $comment->setEmail($email);
            $comment->setAuthor($author);
            $comment->setContent($content);
            $comment->setPostID($post_id);
            $comment->save();
            $jsonResultResponse->setData([
                'result' => 'success',
                'message' => 'Thank you for your submission.'
            ]);
            //send email
            $sender = array('email' => "tan.testmail24993@gmail.com", 'name' => 'Admin');
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder->setTemplateIdentifier($this->_scopeConfig->getValue('blog/general/template', $storeScope))
                ->setTemplateOptions(
                    [
                        'area' =>  \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['name' => $postData['content']])
                ->setFrom($sender)
                ->addTo($postData['email'])
                ->getTransport()
                ->sendMessage();
        } else {
            $jsonResultResponse->setData([
                'result' => 'error',
                'message' => $message
            ]);
        }
        return $jsonResultResponse;
    }
}