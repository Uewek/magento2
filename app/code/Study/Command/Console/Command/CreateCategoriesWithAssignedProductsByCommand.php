<?php
declare(strict_types=1);

namespace Study\Command\Console\Command;

use http\Exception\InvalidArgumentException;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\Area;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\State;
use Magento\Framework\Math\Random;

/**
 * Create 3 categories with 10 products assigned to everyone
 */
class CreateCategoriesWithAssignedProductsByCommand extends Command
{
    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * @var CategoryInterfaceFactory
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
     * @var Random
     */
    private $random;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Product prefix
     */
    private const PRODUCT_PREFIX = 'productPrefix';

    /**
     * Category prefix
     */
    private const CATEGORY_PREFIX = 'categoryPrefix';

    /**
     * Class constructor
     *
     * @param Random $random
     * @param StoreManagerInterface $storeManager
     * @param ProductInterfaceFactory $productFactory
     * @param CategoryInterfaceFactory $categoryFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param State $state
     * @param string|null $name
     */
    public function __construct(
        Random                      $random,
        StoreManagerInterface       $storeManager,
        ProductInterfaceFactory     $productFactory,
        CategoryInterfaceFactory    $categoryFactory,
        ProductRepositoryInterface  $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        State                       $state,
        string                      $name = null
    ) {
        parent::__construct($name);

        $this->random = $random;
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
        $this->state = $state;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

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
        $this->setName('entity-generator');
        $this->setDescription('Create 3 categories with 10 products ');
        $this->setDefinition($options);

        parent::configure();
    }

    /**
     * Main function, creating 3 categories with 10 products in each
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->state->setAreaCode(Area::AREA_GLOBAL);
        if (null === $input->getOption(self::CATEGORY_PREFIX) ||
            null === $input->getOption(self::PRODUCT_PREFIX)) {
            $output->writeln('Enter correct prefix !!');
            throw new InvalidArgumentException(__('Entered incorrect prefix argument!'));
        }

        if (null !== $input->getOption(self::CATEGORY_PREFIX)
            && null !== $input->getOption(self::PRODUCT_PREFIX)) {
            $productPrefix = $input->getOption(self::PRODUCT_PREFIX);
            $categoryPrefix = $input->getOption(self::CATEGORY_PREFIX);

            $categories = $this->createCategories($categoryPrefix);
            foreach ($categories as $category) {
                $this->createAssignedProducts($category, $productPrefix);
            }
            $output->writeln('Products and categories created successfully.');

            return Cli::RETURN_SUCCESS;
        }
    }

    /**
     * Create simple product assigned to category
     *
     * @param string $productName
     * @param int $productCategory
     */
    private function createProduct(string $productName, int $productCategory)
    {
        $stockDataArray = ['use_config_manage_stock' => 0,
            'manage_stock' => 1,
            'is_in_stock' => 1,
            'qty' => 999];
        $product = $this->productFactory->create();
        $product->setSku($productName);
        $product->setName($productName);
        $product->setAttributeSetId($product->getDefaultAttributeSetId());
        $product->setStatus(Status::STATUS_ENABLED);
        $product->setWeight(10);
        $product->setVisibility(Visibility::VISIBILITY_BOTH);
        $product->setTaxClassId(0);
        $product->setTypeId(Type::TYPE_SIMPLE);
        $product->setPrice(100);
        $product->setWebsiteIds($product->getWebsiteIds());
        $product->setCategoryIds($productCategory);
        $product->setStockData($stockDataArray);
        try {
            $this->productRepository->save($product);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Can`t save product'));
        }
    }

    /**
     * Create category
     *
     * @param string $categoryName
     * @return Category
     */
    private function createCategory(string $categoryName): CategoryInterface
    {
        $category = $this->categoryFactory->create();
        $category->setName($categoryName);
        $category->setParentId($this->getRootCategoryId());
        $category->setIsActive(true);
        try {
            $this->categoryRepository->save($category);

        } catch (\Exception $e) {
            throw new LocalizedException(__('Can`t save category'));
        }

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
        return $this->random->getRandomString($length);
    }

    /**
     * Get id of root category
     *
     * @return int
     */
    private function getRootCategoryId(): int
    {
        return (int) $this->storeManager->getStore()->getRootCategoryId();
    }

    /**
     * Create products named with prefix and assigned to given category
     *
     * @param int $categoryId
     * @param string $productPrefix
     * @param int $number
     */
    private function createAssignedProducts(int $categoryId, string $productPrefix, int $number = 10): void
    {
        for ($j = 0; $j < $number; $j++) {
            $this->createProduct($productPrefix . $this->getRandomString(), $categoryId);
        }
    }

    /**
     * Create categories named with prefix and return array with category id`s
     *
     * @param string $categoryPrefix
     * @param int $number
     * @return array
     */
    private function createCategories(string $categoryPrefix, int $number = 3): array
    {
        $categoryIds = [];
        for ($i = 0; $i < $number; $i++) {
            $category = $this->createCategory($categoryPrefix . $this->getRandomString());
            $categoryIds[] = (int)$category->getId();
        }

        return $categoryIds;
    }
}
