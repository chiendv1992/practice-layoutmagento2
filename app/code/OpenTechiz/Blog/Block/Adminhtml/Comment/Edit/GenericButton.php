<?php
namespace OpenTechiz\Blog\Block\Adminhtml\Comment\Edit;
use Magento\Backend\Block\Widget\Context;
class GenericButton
{

    protected $context;
    protected $commentFactory;
    public function __construct(
        Context $context,
        \OpenTechiz\Blog\Model\CommentFactory $commentFactory
    )
    {
        $this->context = $context;
        $this->commentFactory = $commentFactory;
    }
    /**
     * Return Comment ID
     */
    public function getCommentId()
    {
        $id = $this->context->getRequest()->getParam('id');
        $comment = $this->commentFactory->create()->load($id);
        if ($comment->getId())
            return $id;
        return null;
    }
    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}