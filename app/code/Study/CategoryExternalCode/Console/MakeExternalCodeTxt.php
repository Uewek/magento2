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

/**
 * Create .txt file with names of categories and assigned external attributes
 */
class MakeExternalCodeTxt extends Command
{
    /**
     * @var Filesystem
     */
    private $filesystem;

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
        Filesystem        $filesystem,
        CollectionFactory $collectionFactory,
        string            $name = null
    ) {
        parent::__construct($name);

        $this->collectionFactory = $collectionFactory;
        $this->filesystem = $filesystem;
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
        $this->createTextFile();
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
        $externalCollection->addFieldToSelect(CategoryExternalCodeRepositoryInterface::CATEGORY_NAME);

        foreach ($externalCollection as $item) {
            $name = $item->getData()[CategoryExternalCodeRepositoryInterface::CATEGORY_NAME];
            $code = $item->getData()[CategoryExternalCodeRepositoryInterface::EXTERNAL_CODE];
            $result = $result . $name . ' => ' . $code . "\r\n";
        }

        return $result;
    }

    /**
     * Create file with given content in 'var' directory
     */
    private function createTextFile()
    {
        $varDirectory = $this->filesystem->getDirectoryWrite(
            DirectoryList::VAR_DIR
        );
        $content = $this->prepareFileData();
        $varDirectory->writeFile($this->prepareFileName(), $content);
    }

    /**
     * Prepare file name
     *
     * @return string
     */
    private function prepareFileName(): string
    {
        return 'category_codes_' . date("d_m_Y") . '.txt';
    }

}
