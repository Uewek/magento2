<?php
declare(strict_types=1);

namespace Study\ProductLikes\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::ERROR;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/app/code/Study/ProductLikes/Logger/log/likeslog.log';
}
