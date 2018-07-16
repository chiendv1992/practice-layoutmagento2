<?php
namespace OpenTechiz\Blog\Model\Comment\Source;
use Magento\Framework\Data\OptionSourceInterface;
class Status implements OptionSourceInterface
{
    protected $banner;
    public function __construct(\OpenTechiz\Blog\Model\Comment $banner)
    {
        $this->banner = $banner;
    }
    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->banner->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}