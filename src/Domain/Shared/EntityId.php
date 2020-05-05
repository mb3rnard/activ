<?php

namespace App\Domain\Shared;

use Ramsey\Uuid\UuidInterface;

final class EntityId
{
    private UuidInterface $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function fromUuid(UuidInterface $id): self
    {
        return new self($id);
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }
}
