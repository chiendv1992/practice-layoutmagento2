<?php
namespace OpenTechiz\Blog\Ui\Component\Listing\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
class CommentActions extends Column
{

    const BLOG_URL_PATH_EDIT_COMMENT = 'blog/comment/edit';
    const BLOG_URL_PATH_DELETE_COMMENT = 'blog/comment/delete';

    protected $urlBuilder;

    private $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::BLOG_URL_PATH_EDIT_COMMENT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['comment_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['comment_id' => $item['comment_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE_COMMENT, ['comment_id' => $item['comment_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.author }\'s comment"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.author }\'s comment')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}