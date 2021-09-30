<?php
declare(strict_types=1);

namespace Study\Command\Console\Command;

use Magento\Catalog\Model\Category;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\State;

class CreateCategoriesWithAssignedProductsByCommand extends Command
{
    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var State
     */
    private $state;

    /**
     * Product prefix
     */
    private const PRODUCT_PREFIX = 'productPrefix';

    /**
     * Category prefix
     */
    private const CATEGORY_PREFIX = 'categoryPrefix';

    /**
     * Set command options, name and description
     */
    protected function configure(): void
    {
        $options = [
            new InputOption(
                self::CATEGORY_PREFIX,
                null,
                InputOption::VALUE_REQUIRED,
                'category prefix'
            ),
            new InputOption(
                self::PRODUCT_PREFIX,
                null,
                InputOption::VALUE_REQUIRED,
                'product prefix'
            )
        ];
        $this->setName('command:createCategoriesAndProductsByCommand');
        $this->setDescription('Create 3 categories with 10 products ');
        $this->setDefinition($options);

        parent::configure();
    }

    /**
     * Class constructor
     *
     * @param ProductFactory $productFactory
     * @param CategoryFactory $categoryFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param State $state
     * @param string|null $name
     */
    public function __construct
    (
        ProductFactory              $productFactory,
        CategoryFactory             $categoryFactory,
        ProductRepositoryInterface  $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        State                       $state,
        string                      $name = null
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
        $this->state = $state;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;

        parent::__construct($name);
    }

    /**
     * Main function, creating 3 categories with 10 products in each
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->state->setAreaCode('frontend');

        if (null !== $input->getOption(self::CATEGORY_PREFIX)
            && null !== $input->getOption(self::PRODUCT_PREFIX)) {
            $productPrefix = $input->getOption(self::PRODUCT_PREFIX);
            $categoryPrefix = $input->getOption(self::CATEGORY_PREFIX);
            for ($i = 0; $i < 3; $i++) {
                $category = $this->createCategory($categoryPrefix . $this->getRandomString());
                $parentCatergoryId = (int)$category->getId();
                for ($j = 0; $j < 10; $j++) {
                    $this->createProduct($productPrefix . $this->getRandomString(), $parentCatergoryId);
                }
            }
            $output->writeln('Products and categories created successfully.');
        }

        if (null === $input->getOption('categoryPrefix') || null === $input->getOption('productPrefix')) {
            $output->writeln('Enter correct prefix !!');
        }
    }

    /**
     * Create simple product assigned to category
     *
     * @param string $productName
     * @param int $productCategory
     */
    private function createProduct(string $productName , int $productCategory ): void
    {
        $product = $this->productFactory->create();
        $product->setSku($productName);
        $product->setUrlKey($productName);
        $product->setName($productName);
        $product->setAttributeSetId(4);
        $product->setStatus(1);
        $product->setWeight(10);
        $product->setVisibility(4);
        $product->setTaxClassId(0);
        $product->setTypeId('simple');
        $product->setPrice(100);
        $product->setWebsiteIds(array(1));
        $product->setCategoryIds($productCategory);
        $product->setStockData(
            array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1,
                'qty' => 999
            )
        );
        $this->productRepository->save($product);
    }

    /**
     * Create category
     *
     * @param string $categoryName
     * @return Category
     */
    private function createCategory(string $categoryName): Category
    {
        $category = $this->categoryFactory->create();
        $category->setName($categoryName);
        $category->setParentId(2);
        $category->setIsActive(true);
        $this->categoryRepository->save($category);

        return $category;
    }

    /**
     * Get random string by given length
     *
     * @param int $length
     * @return string
     */
    private function getRandomString(int $length = 8): string
    {
        return bin2hex(random_bytes($length));
    }
}
