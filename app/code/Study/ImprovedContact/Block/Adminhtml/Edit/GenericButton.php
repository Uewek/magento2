<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

/**
 * Class GenericButton - base class for all buttons on the contact edit page
 */
class GenericButton
{
    /**
     * Registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * GenericButton constructor.
     *
     * @param UrlInterface $urlBuilder
     * @param Registry $registry
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Registry $registry
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->registry = $registry;
    }

    /**
     * Return the synonyms group Id.
     *
     * @return int
     */
    public function getId(): int
    {
        $contact = $this->registry->registry('contact');

        return $contact ;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route, $params): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
