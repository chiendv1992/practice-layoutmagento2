<?php
namespace OpenTechiz\Blog\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $_resultPageFactory;

	function __construct(
		\Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
	{
		$this->_resultPageFactory=$resultPageFactory;
		parent::__construct($context);
	}

	public function execute(){
		return $this->_resultPageFactory->create();
	}
}
