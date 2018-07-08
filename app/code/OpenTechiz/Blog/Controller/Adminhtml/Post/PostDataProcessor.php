<?php

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

class PostDataProcessor
{

    protected $messageManager;
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {

        $this->messageManager = $messageManager;
    }

    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'url_key' => __('URL Key'),
            'title' => __('Post Title'),
            'content' => __('Content'),
            'is_active' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }


}
