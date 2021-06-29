<?php


namespace Study\AdvancedContactForm\Plugin\Controller\Index;


use Magento\Contact\Controller\Index\Post as PostController;
use Magento\Store\Model\StoreManagerInterface;
use Study\AdvancedContactForm\Model\AdvancedContactFormFactory;

class Post2
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param AdvancedContactFormFactory $advancedContactFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        AdvancedContactFormFactory $advancedContactFactory
    ) {
        $this->storeManager = $storeManager;
        $this->advancedContactFactory = $advancedContactFactory;
    }

    /**
     * @param PostController $subject
     * @throws \Exception
     */
    public function afterExecute(PostController $subject,$result)
    {
        $data = $subject->getRequest()->getPostValue();
        $this->advancedContactFactory->create()
            ->addData($data)
            ->save();
        return $result;
    }

}
