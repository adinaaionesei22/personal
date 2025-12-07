<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Model
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Model;

use Evonomix\Ribbon\Api\Data\RibbonInterface;
use Evonomix\Ribbon\Model\ResourceModel\Ribbon as RibbonResourceModel;
use Magento\Framework\Model\AbstractModel;

class Ribbon extends AbstractModel implements RibbonInterface
{
    /**
     * Display pages constants
     */
    const DISPLAY_ALL_PAGES = 0;
    const DISPLAY_HOMEPAGE_ONLY = 1;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(RibbonResourceModel::class);
    }

    /**
     * Get ribbon ID
     *
     * @return int|null
     */
    public function getId()
    {
        return parent::getId();
    }

    /**
     * Set ribbon ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id): RibbonInterface
    {
        return parent::setId($id);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData('title');
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): RibbonInterface
    {
        return $this->setData('title', $title);
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->getData('description');
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(?string $description): RibbonInterface
    {
        return $this->setData('description', $description);
    }

    /**
     * Get link
     *
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->getData('link');
    }

    /**
     * Set link
     *
     * @param string $link
     * @return $this
     */
    public function setLink(?string $link): RibbonInterface
    {
        return $this->setData('link', $link);
    }

    /**
     * Get band color
     *
     * @return string
     */
    public function getBandColor(): string
    {
        return $this->getData('band_color');
    }

    /**
     * Set band color
     *
     * @param string $bandColor
     * @return $this
     */
    public function setBandColor(string $bandColor): RibbonInterface
    {
        return $this->setData('band_color', $bandColor);
    }

    /**
     * Get start date
     *
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->getData('start_date');
    }

    /**
     * Set start date
     *
     * @param string $startDate
     * @return $this
     */
    public function setStartDate(string $startDate): RibbonInterface
    {
        return $this->setData('start_date', $startDate);
    }

    /**
     * Get end date
     *
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->getData('end_date');
    }

    /**
     * Set end date
     *
     * @param string $endDate
     * @return $this
     */
    public function setEndDate(string $endDate): RibbonInterface
    {
        return $this->setData('end_date', $endDate);
    }

    /**
     * Get display pages
     *
     * @return int
     */
    public function getDisplayPages(): int
    {
        return (int)$this->getData('display_pages');
    }

    /**
     * Set display pages
     *
     * @param int $displayPages
     * @return $this
     */
    public function setDisplayPages(int $displayPages): RibbonInterface
    {
        return $this->setData('display_pages', $displayPages);
    }

    /**
     * Get is active
     *
     * @return int
     */
    public function getIsActive(): int
    {
        return (int)$this->getData('is_active');
    }

    /**
     * Set is active
     *
     * @param int $isActive
     * @return $this
     */
    public function setIsActive(int $isActive): RibbonInterface
    {
        return $this->setData('is_active', $isActive);
    }

    /**
     * Check if ribbon is currently active based on date range
     *
     * @return bool
     */
    public function isActive(): bool
    {
        if (!$this->getIsActive()) {
            return false;
        }

        $now = new \DateTime();
        $startDate = new \DateTime($this->getStartDate());
        $endDate = new \DateTime($this->getEndDate());

        return ($now >= $startDate && $now <= $endDate);
    }

    /**
     * Check if ribbon should be displayed on current page
     *
     * @param bool $isHomepage
     * @return bool
     */
    public function shouldDisplayOnPage(bool $isHomepage = false): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->getDisplayPages() == self::DISPLAY_HOMEPAGE_ONLY) {
            return $isHomepage;
        }

        return true;
    }
}

