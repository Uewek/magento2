<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Study\Promotions\Api\PromotionsInfoInterface;
use Study\Promotions\Model\ResourceModel\PromotionsInfoResource;
use Magento\Framework\Model\AbstractModel;


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


    public function setStartTime(string $time): PromotionsInfoInterface
    {
        $this->setData('start_time', $time);

        return $this;
    }

    public function setStatus(bool $status): PromotionsInfoInterface
    {
        $this->setData('promotion_enabled', $status);

        return $this;
    }

    public function setDescription(string $description): PromotionsInfoInterface
    {
        $this->setData('promotion_description', $description);

        return $this;
    }

    public function getStartTime()
    {
        return $this->getData('start_time');
    }

    public function getFinishTime()
    {
        return $this->getData('finish_time');
    }
}
