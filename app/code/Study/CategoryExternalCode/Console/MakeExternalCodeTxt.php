<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Console;

use Magento\Framework\Console\Cli;
use Study\CategoryExternalCode\Api\CategoryExternalCodeRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;
use Study\CategoryExternalCode\Service\CreateTxtFileService;
use Magento\Catalog\Model\CategoryRepository;

/**
 * Create .txt file with names of categories and assigned external attributes
 */
class MakeExternalCodeTxt extends Command
{
    /**
     * @var CategoryRepository
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
     * @param Filesystem $filesystem
     * @param CollectionFactory $collectionFactory
     * @param string|null $name
     */
    public function __construct(
        Filesystem           $filesystem,
        CategoryRepository   $categoryRepository,
        CreateTxtFileService $createTxtFileService,
        CollectionFactory    $collectionFactory,
        string               $name = null
    ) {
        parent::__construct($name);

        $this->collectionFactory = $collectionFactory;
        $this->categoryRepository = $categoryRepository;
        $this->createTxtFileService = $createTxtFileService;
    }

    /**
     * Configure command description
     */
    protected function configure()
    {
        $this->setName('external:maketxt');
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
        $externalCollection->addFieldToSelect(CategoryExternalCodeRepositoryInterface::EXTERNAL_CODE);
        $externalCollection->addFieldToSelect(CategoryExternalCodeRepositoryInterface::CATEGORY_ID);

        foreach ($externalCollection as $item) {
            $id = (int) $item->getData(CategoryExternalCodeRepositoryInterface::CATEGORY_ID);
            $name = $this->getCategoryName($id);
            $code = $item->getData(CategoryExternalCodeRepositoryInterface::EXTERNAL_CODE);

            if (isset($code) && $code !== '') {
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
        return 'category_codes_' . date('d_m_Y') . '.txt';
    }

    /**
     * Get category name by id
     *
     * @param int $categoryId
     * @return string
     */
    private function getCategoryName(int $categoryId): string
    {
        try {
            $category = $this->categoryRepository->get($categoryId);
        } catch (\Exception $e) {

        }
        return $category->getName();
    }
}
