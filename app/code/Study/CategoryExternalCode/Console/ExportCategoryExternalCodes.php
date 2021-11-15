<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Console;

use Magento\Framework\Console\Cli;
use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;
use Study\CategoryExternalCode\Service\CreateTxtFileService;
use Magento\Catalog\Api\CategoryRepositoryInterface;

/**
 * Create .txt file with names of categories and assigned external attributes
 */
class ExportCategoryExternalCodes extends Command
{
    /**
     * @var TimezoneInterface
     */
    private $timeZone;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CreateTxtFileService
     */
    private $createTxtFileService;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Class constructor
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param TimezoneInterface $timeZone
     * @param CreateTxtFileService $createTxtFileService
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CategoryRepositoryInterface   $categoryRepository,
        CreateTxtFileService $createTxtFileService,
        TimezoneInterface    $timeZone,
        CollectionFactory    $collectionFactory
    ) {
        parent::__construct();

        $this->collectionFactory = $collectionFactory;
        $this->timeZone = $timeZone;
        $this->categoryRepository = $categoryRepository;
        $this->createTxtFileService = $createTxtFileService;
    }

    /**
     * Configure command description
     */
    protected function configure()
    {
        $this->setName('external-category-codes:export');
        $this->setDescription('Make txt file with contain category names and external codes');

        parent::configure();
    }

    /**
     * Main function
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileContent = $this->prepareFileData();
        $filename = $this->prepareFileName();
        $this->createTxtFileService->createTextFile($fileContent, $filename);
        $output->writeln($this->prepareFileName() . " file created in 'var\' directory");

        return Cli::RETURN_SUCCESS;
    }

    /**
     * Prepare content of .txt file
     *
     * @return string
     */
    private function prepareFileData(): string
    {
        $result = '';
        $externalCollection = $this->collectionFactory->create();
        $externalCollection->addFieldToSelect(CategoryExternalCodeInterface::EXTERNAL_CODE);
        $externalCollection->addFieldToSelect(CategoryExternalCodeInterface::CATEGORY_ID);

        foreach ($externalCollection as $item) {
            $id = (int) $item->getData(CategoryExternalCodeInterface::CATEGORY_ID);
            $name = $this->getCategoryName($id);
            $code = $item->getData(CategoryExternalCodeInterface::EXTERNAL_CODE);

            if (null !== $code && $code !== '') {
                $result = $result . $name . ' => ' . $code . "\r\n";
            }
        }

        return $result;
    }

    /**
     * Prepare file name
     *
     * @return string
     */
    private function prepareFileName(): string
    {
        $currentDate = $this->timeZone->date()->format('d_m_Y');
        return 'category_codes_' . $currentDate . '.txt';
    }

    /**
     * Get category name by id
     *
     * @param int $categoryId
     * @return string|null
     */
    private function getCategoryName(int $categoryId): ?string
    {
        $result = null;
        try {
            $category = $this->categoryRepository->get($categoryId);
            $result = $category->getName();
        } catch (\Exception $e) {

        }

        return $result;
    }
}
