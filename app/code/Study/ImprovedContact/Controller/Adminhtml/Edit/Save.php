<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Study\ImprovedContact\Model\ContactRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

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
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Save constructor.
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ContactRepository $contactRepository
    ) {
        $this->repository = $contactRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
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
        $list=$this->repository->getList($this->setSearchCriteria('contact_id', 25));
        $data = $this->getRequest()->getParams();
        try {
            $this->repository->validateData($data);
            $contact = $this->repository->getById((int)$data['contact_id']);
            $contact->setTelephone($data['telephone'])->setName($data['name'])->setComment($data['comment']);
            $this->repository->save($contact);

            return $resultRedirect;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));

            return $resultRedirect;
        }
    }

    /**
     * Prepare and set searchCriteria
     *
     * @param string $field
     * @param string|int $value
     * @return \Magento\Framework\Api\SearchCriteria
     */
    private function setSearchCriteria($field, $value)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter($field, $value)->create();

        return $searchCriteria;
    }
}
