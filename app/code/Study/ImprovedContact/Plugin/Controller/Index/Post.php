<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Plugin\Controller\Index;

use Magento\Contact\Controller\Index\Post as PostController;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Store\Model\StoreManagerInterface;
use Study\ImprovedContact\Model\AdvancedContactFormFactory;
use Study\ImprovedContact\Model\Config;

class Post
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var AdvancedContactFormFactory
     */
    private $advancedContactFormFactory;

    /**
     * Post constructor.
     * @param StoreManagerInterface $storeManager
     * @param AdvancedContactFormFactory $advancedContactFormFactory
     * @param Config $config
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        AdvancedContactFormFactory $advancedContactFormFactory,
        Config $config
    ) {
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->advancedContactFormFactory = $advancedContactFormFactory;
    }

    /**
     * Add data from contact form to table
     *
     * @param PostController $subject
     * @param Redirect $result
     * @return mixed
     */
    public function afterExecute(PostController $subject, Redirect $result): Redirect
    {
        if ($this->config->isEnabled()) {
            $data = $subject->getRequest()->getPostValue();
            $this->advancedContactFormFactory->create()
                ->addData($data)
                ->save();
            return $result;
        } else {
            return $result;
        }
    }
}
