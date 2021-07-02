<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Plugin\Model;

use Magento\Contact\Model\Mail as ContactMailModel;
use Magento\Contact\Controller\Index\Post as PostController;
use Study\ImprovedContact\Model\ContactorInfoFactory;
use Study\ImprovedContact\Model\Config;

class Post
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var ContactorInfoFactory
     */
    private $contactorInfoFactory;

    /**
     * @var PostController
     */
    private $postController;

    /**
     * Post constructor.
     * @param ContactorInfoFactory $contactorInfoFactory
     * @param Config $config
     * @param PostController $postController
     */
    public function __construct(
        ContactorInfoFactory $contactorInfoFactory,
        Config $config,
        PostController $postController

    ) {
        $this->postController = $postController;
        $this->config = $config;
        $this->contactorInfoFactory = $contactorInfoFactory;
    }

    /**
     * Add data from contact form to table
     *
     * @param ContactMailModel $subject
     * @return void
     */
    public function aroundSend(ContactMailModel $subject ) {
        if ($this->config->isEnabled()) {
            $data = $this->postController->getRequest()->getPostValue();
            $this->contactorInfoFactory->create()
                ->addData(['name' => $data['name'], 'email' => $data['email'],
                    'telephone' => $data['telephone'], 'comment' => $data['comment']])
                ->save();
        }
    }
}
