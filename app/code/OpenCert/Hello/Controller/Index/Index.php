<?php
 
namespace OpenCert\Hello\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_registry;
    protected $_logger;

    public function __construct(Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magento\Framework\Registry $registry,
                                \Psr\Log\LoggerInterface $logger)
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_registry = $registry;
        $this->_logger = $logger;
        parent::__construct($context);
    }
 

    public function execute()
    {
        $this->_registry->register('custom_var', 'Test Value');
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;

//        debug backtrace
//        $debugBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
////        echo "<pre>";
//        foreach ($debugBackTrace as $item)
//        {
//            echo @$item['class'] . @$item['type'] . @$item['function'] . "\n";
//            echo "<pre>";
////            print_r( $item);
//        }

    }


}