<?php
declare(strict_types=1);

namespace Study\Promotions\Setup;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Study\Promotions\Model\PromotionsInfoFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Study\Promotions\Model\PromotionsRepository;

/**
 * Create 3 promotions
 */
class DataPatch implements DataPatchInterface
{
    /**
     * @var PromotionsInfoFactory
     */
    private $promotionsInfoFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;


    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    public function __construct
    (
        PromotionsInfoFactory $promotionsInfoFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        PromotionsRepository $promotionsRepository
    ) {
        $this->promotionsInfoFactory = $promotionsInfoFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->promotionsRepository = $promotionsRepository;
    }

    /**
     * Create 3 promotions with random data
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();
        for ($i = 0; $i < 3; $i++) {
            $promotion = $this->promotionsInfoFactory->create()
                ->setDescription(bin2hex(random_bytes(8)))
                ->setName(bin2hex(random_bytes(8)))
                ->setStatus(true)
                ->setStartTime('09/14/2021 3:44 AM')
                ->setFinishTime('09/14/2022 3:44 AM');
            $this->promotionsRepository->savePromotion($promotion);
        }

    }

    /**
     * @inheirtDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheirtDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}