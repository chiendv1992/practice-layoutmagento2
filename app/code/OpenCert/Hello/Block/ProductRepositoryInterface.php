<?php

namespace OpenCert\Hello\Block;
class ProductRepositoryInterface extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;
//    private $productFactory;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
//        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []
    )
    {
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);

//        $this->productFactory = $productFactory;
    }

    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
}
?>