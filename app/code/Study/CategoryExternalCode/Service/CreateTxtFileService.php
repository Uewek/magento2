<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Service;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Create .txt file with given content and filename in \var directory
 */
class CreateTxtFileService
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Class constructor
     *
     * @param Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * Create file with given content and filename in 'var' directory
     */
    public function createTextFile(string $content, string $filename)
    {
        $varDirectory = $this->filesystem->getDirectoryWrite(
            DirectoryList::VAR_DIR
        );
        $varDirectory->writeFile($filename, $content);
    }
}
