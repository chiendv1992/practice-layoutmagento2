<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;
class SaveComment extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;
    protected $_request;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    )
    {
        $this->_request = $request;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }
    public function getFormAction()
    {
        $url = $this->getUrl('*/*', ['_direct' => 'blog/comment/save', '_use_rewrite' => true]);
        return $url;
    }
    public function getLoadUrl()
    {
        $url = $this->getUrl().'blog/comment/load';
        return $url;
    }
    public function getPostId()
    {
        return $this->_request->getParam('post_id', false);
    }
    public function isLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }
}