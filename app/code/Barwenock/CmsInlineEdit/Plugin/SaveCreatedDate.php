<?php
declare(strict_types=1);

namespace Barwenock\CmsInlineEdit\Plugin;

use DateTimeZone;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
class SaveCreatedDate
{
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    public function __construct(
        TimezoneInterface $timezone
    ) {
        $this->timezone = $timezone;
    }

    public function beforeSave($subject, $block)
    {
        $time = $block->getCreationTime();
        $time = new \DateTime($time);
        $time = $time->setTimezone(new DateTimeZone($this->timezone->getConfigTimezone()))->format('Y/m/d H:i:s');
        $block->setCreationTime($time);

        return [$block];
    }

}
