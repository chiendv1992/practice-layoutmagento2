<?php
namespace OpenTechiz\Blog\Cron;

class Run
{
    protected $_logger;
    protected $_commentCollecionFactory;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $scopeConfig;
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionfactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_logger = $logger;
        $this->_commentCollecionFactory = $commentCollectionfactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $this->_logger->debug('Cron run successfully');
        $comments = $this->_commentCollecionFactory->create()
            ->addFilter('is_active', 0);
        if(count($comments) > 0)
        {
            //send email
            $sender = array('email' => "chiendv1992@gmail.com", 'name' => 'BOSS');
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder->setTemplateIdentifier($this->scopeConfig->getValue('blog/general/template', $storeScope))
                ->setTemplateOptions(
                    [
                        'area' =>  \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([])
                ->setFrom($sender)
                ->addTo('chiendv92@gmail.com') //send to
                ->getTransport()
                ->sendMessage();
        }

        return $this;
    }
}