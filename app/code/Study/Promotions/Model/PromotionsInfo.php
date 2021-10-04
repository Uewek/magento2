<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Study\Promotions\Api\PromotionsInfoInterface;
use Study\Promotions\Model\ResourceModel\PromotionsInfoResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Promotions model
 */
class PromotionsInfo extends AbstractModel implements PromotionsInfoInterface
{
    /**
     * Promotions model constructor
     */
    protected function _construct(): void
    {
        $this->_init(PromotionsInfoResource::class);
    }

    /**
     * Get promotion name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData('promotion_name');
    }

    /**
     * Set promotion name
     *
     * @param string $name
     * @return PromotionsInfoInterface
     */
    public function setName(string $name): PromotionsInfoInterface
    {
        $this->setData('promotion_name', $name);

        return $this;
    }

    /**
     * Set promotion start time
     *
     * @param string $time
     * @return PromotionsInfoInterface
     */
    public function setStartTime(string $time): PromotionsInfoInterface
    {
        $this->setData('start_time', $time);

        return $this;
    }

    /**
     * Set promotion enabled/disabled status
     *
     * @param bool $status
     * @return PromotionsInfoInterface
     */
    public function setStatus(bool $status): PromotionsInfoInterface
    {
        $this->setData('promotion_enabled', $status);

        return $this;
    }

    /**
     * Set promotion description
     *
     * @param string $description
     * @return PromotionsInfoInterface
     */
    public function setDescription(string $description): PromotionsInfoInterface
    {
        $this->setData('promotion_description', $description);

        return $this;
    }

    /**
     * Get promotion start time
     *
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->getData('start_time');
    }

    /**
     * Get  promotion finish time
     *
     * @return string
     */
    public function getFinishTime(): string
    {
        return $this->getData('finish_time');
    }
}
