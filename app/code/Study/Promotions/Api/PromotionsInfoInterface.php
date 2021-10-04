<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotionsInfoInterface
{
    /**
     * Get promotion name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set promotion name
     *
     * @param string $name
     * @return PromotionsInfoInterface
     */
    public function setName(string $name): PromotionsInfoInterface;

    /**
     * Set promotion start time
     *
     * @param string $time
     * @return PromotionsInfoInterface
     */
    public function setStartTime(string $time): PromotionsInfoInterface;

    /**
     * Set promotion enabled/disabled status
     *
     * @param bool $status
     * @return PromotionsInfoInterface
     */
    public function setStatus(bool $status): PromotionsInfoInterface;

    /**
     * Set promotion description
     *
     * @param string $description
     * @return PromotionsInfoInterface
     */
    public function setDescription(string $description): PromotionsInfoInterface;
}
