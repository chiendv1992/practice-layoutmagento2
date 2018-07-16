<?php
namespace OpenTechiz\Blog\Ui\Component\Listing\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
/**
 * Class PageActions
 */
class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Url path
     */
    const COMMENT_URL_PATH_EDIT = 'blog/comment/edit';
    const COMMENT_URL_PATH_DELETE = 'blog/comment/delete';
    protected $urlBuilder;
    private $editUrl;
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::COMMENT_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     */
    public function prepareDataSource(array $dataSource)
    {
//        echo "<pre>";
//        var_dump($dataSource);
//        echo "</pre>";
//        echo "saf";die();
        if (isset($dataSource['data']['items'])) {
            // Get column name
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['comment_id'])) {
                    // Add Edit link
                    $item[$fieldName]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['comment_id']]),
                        'label' => __('Edit')
                    ];
                    // Add Delete link
                    $item[$fieldName]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::COMMENT_URL_PATH_DELETE, ['id' => $item['comment_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.image }'),
                            'message' => __('Are you sure you wan\'t to delete this record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}