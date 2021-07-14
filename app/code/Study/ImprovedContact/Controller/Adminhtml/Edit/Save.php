<?php


namespace Study\ImprovedContact\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Study\ImprovedContact\Model\ContactRepository;

class Save extends Action implements HttpPostActionInterface
{

    /**
     * @var ContactRepository
     */
    private $repository;

    /**
     * Save constructor.
     * @param Context $context
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        Context $context,
        ContactRepository $contactRepository
    ) {
        $this->repository = $contactRepository;
        parent::__construct($context);
    }

    /**
     * Save contact with new data
     *
     * @return Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if (isset($data['contact_id'])) {
            $contact = $this->repository->getById($data['contact_id']);
            $contact->setTelephone($data['telephone'])->setName($data['name'])->setComment($data['comment']);
            $this->repository->save($contact);
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('improvedcontact/');
            return $resultRedirect;
        }
    }
}
