<?php
declare(strict_types=1);

namespace Study\Promotions\Setup\Patch\Data;

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

    /**
     * @param PromotionsInfoFactory $promotionsInfoFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PromotionsRepository $promotionsRepository
     */
    public function __construct(
        PromotionsInfoFactory    $promotionsInfoFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        PromotionsRepository     $promotionsRepository
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
                ->setStatus(1)
                ->setStartTime(date('m/d/Y H:i A'))
                ->setFinishTime(date('d/m/Y H:i A', strtotime('+1 day')));
            $this->promotionsRepository->save($promotion);
        }
    }

    /**
     * Return dependencies
     *
     * @inheirtDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Return aliases
     *
     * @inheirtDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
