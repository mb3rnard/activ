<?php

namespace App\Domain\Shared;

use DateTimeInterface;

trait TimestampableTrait
{
    private DateTimeInterface $createdAt;

    private DateTimeInterface $updatedAt;

    /**
     * Init a timestampable model by setting current or given date as creation and update dates.
     */
    private function initTimestampable(?\DateTimeInterface $createdAt = null): void
    {
        $this->createdAt = $createdAt ?: new \DateTime();
        $this->updatedAt = $this->createdAt;
    }

    private function markAsUpdated(?\DateTimeInterface $updatedAt = null): void
    {
        $this->updatedAt = $updatedAt ?: new \DateTime();
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @internal For fixtures only
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt = null): void
    {
        $this->createdAt = $createdAt ?: new \DateTime();
    }
}
