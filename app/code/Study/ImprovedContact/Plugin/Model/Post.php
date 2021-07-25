<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Plugin\Model;

use Magento\Framework\App\Request\Http;
use Study\ImprovedContact\Model\ContactorInfoFactory;
use Study\ImprovedContact\Model\Config;
use Study\ImprovedContact\Model\ContactRepository;

/**
 * Class Post that plugin save data from contact form
 */
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
     * @var ContactRepository
     */
    private $repository;

    /**
     * @var Http
     */
    protected $request;

    /**
     * Post constructor.
     *
     * @param Http $request
     * @param ContactorInfoFactory $contactorInfoFactory
     * @param Config $config
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        Http $request,
        ContactorInfoFactory $contactorInfoFactory,
        Config $config,
        ContactRepository $contactRepository
    ) {
        $this->config = $config;
        $this->contactorInfoFactory = $contactorInfoFactory;
        $this->repository = $contactRepository;
        $this->request = $request;
    }

    /**
     * Add data from contact form to table
     *
     * @return void
     */
    public function beforeSend(): void
    {
        if ($this->config->isEnabled()) {
            $data = $this->request->getParams();
            $newContact=$this->contactorInfoFactory->create()
                ->setEmail($data['email'])->setName($data['name'])
                ->setTelephone($data['telephone'])->setComment($data['comment']);
            $this->repository->save($newContact);
        }
    }
}
