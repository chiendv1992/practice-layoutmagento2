<?php
namespace OpenTechiz\Blog\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $_scopeConfig;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
        ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->_scopeConfig = $scopeConfig;
    }

    public function sendEmail($author, $sender, $email)
    {

        try {
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $this->inlineTranslation->suspend();
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->_scopeConfig->getValue('blog/general/template', $storeScope))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $author])
                ->setFrom($sender)
                ->addTo($email)
                ->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    public function remindEmail($commentCount, $email_admin, $name)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $sender_admin = [
            'name' => 'Remind Approve Comment',
            'email' => 'sondt1610@gmail.com'
        ];
        $postObject = new \Magento\Framework\DataObject();
        $data['name'] = $name;
        $data['comment_count'] = $commentCount;
        $data['subject'] = "ADMIN: $commentCount comment(s) waiting for approval";
        $postObject->setData($data);
        $transport = $this->transportBuilder
            ->setTemplateIdentifier($this->_scopeConfig->getValue('blog/reminder/template', $storeScope))
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($sender_admin)
            ->addTo($email_admin)
            ->getTransport()
            ->sendMessage();
    }
}