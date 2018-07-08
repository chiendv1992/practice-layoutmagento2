<?php
namespace OpenTechiz\Blog\Block\Adminhtml\Comment;
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry = null;
 
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'comment_id';
        $this->_blockGroup = 'OpenTechiz_Blog';
        $this->_controller = 'adminhtml_comment';
        parent::_construct();
        if ($this->_isAllowedAction('OpenTechiz_Blog::save_comment')) {
            $this->buttonList->update('save', 'label', __('Save Comment'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }
        if ($this->_isAllowedAction('OpenTechiz_Blog::comment_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Post'));
        } else {
            $this->buttonList->remove('delete');
        }
    }
    
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('blog_post')->getId()) {
            return __("Edit Comment '%1'", $this->escapeHtml($this->_coreRegistry->registry('blog_comment')->getTitle()));
        } else {
            return __('New Comment');
        }
    }
    
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('blog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}