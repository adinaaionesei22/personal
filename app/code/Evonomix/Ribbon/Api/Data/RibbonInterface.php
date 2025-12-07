<?php
declare(strict_types=1);

/**
 * Evonomix Ribbon Interface
 *
 * @category  Evonomix
 * @package   Evonomix_Ribbon
 */

namespace Evonomix\Ribbon\Api\Data;

interface RibbonInterface
{
    /**
     * Get ribbon ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ribbon ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id): RibbonInterface;

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): RibbonInterface;

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(?string $description): RibbonInterface;

    /**
     * Get link
     *
     * @return string|null
     */
    public function getLink(): ?string;

    /**
     * Set link
     *
     * @param string $link
     * @return $this
     */
    public function setLink(?string $link): RibbonInterface;

    /**
     * Get band color
     *
     * @return string
     */
    public function getBandColor(): string;

    /**
     * Set band color
     *
     * @param string $bandColor
     * @return $this
     */
    public function setBandColor(string $bandColor): RibbonInterface;

    /**
     * Get start date
     *
     * @return string
     */
    public function getStartDate(): string;

    /**
     * Set start date
     *
     * @param string $startDate
     * @return $this
     */
    public function setStartDate(string $startDate): RibbonInterface;

    /**
     * Get end date
     *
     * @return string
     */
    public function getEndDate(): string;

    /**
     * Set end date
     *
     * @param string $endDate
     * @return $this
     */
    public function setEndDate(string $endDate): RibbonInterface;

    /**
     * Get display pages
     *
     * @return int
     */
    public function getDisplayPages(): int;

    /**
     * Set display pages
     *
     * @param int $displayPages
     * @return $this
     */
    public function setDisplayPages(int $displayPages): RibbonInterface;

    /**
     * Get is active
     *
     * @return int
     */
    public function getIsActive(): int;

    /**
     * Set is active
     *
     * @param int $isActive
     * @return $this
     */
    public function setIsActive(int $isActive): RibbonInterface;
}

