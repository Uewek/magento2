<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Study\ImprovedContact\Model\ContactRepository;
use Study\ImprovedContact\Model\Validator;

/**
 * Class Save - this controller saving contact after edit
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var ContactRepository
     */
    private $repository;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Save constructor.
     * @param Context $context
     * @param Validator $validator
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        Context $context,
        Validator $validator,
        ContactRepository $contactRepository
    ) {
        $this->repository = $contactRepository;
        $this->validator = $validator;
        parent::__construct($context);
    }

    /**
     * Save contact with new data
     *
     * @return Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('improvedcontact/');
        $data = $this->getRequest()->getParams();
        try {
            $this->validator->validate($data);
            $contact = $this->repository->getById((int)$data['contact_id']);
            $contact->setTelephone($data['telephone'])
                ->setName($data['name'])
                ->setComment($data['comment'])
                ->setEmail($data['email']);
            $this->repository->save($contact);
            $this->messageManager->addSuccessMessage(__('Contact saved successfully !'));

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        return $resultRedirect;
    }
}
