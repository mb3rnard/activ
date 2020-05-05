<?php

namespace App\Infra\Doctrine\Types;

use Ramsey\Uuid\Uuid;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use App\Domain\Shared\EntityId;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EntityIdType extends Type
{
    const NAME = 'identifier';

    /**
     * {@inheritdoc}
     *
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $value
     * @param AbstractPlatform $platform
     *
     * @return EntityId
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        try {
            $identifier = EntityId::fromUuid(Uuid::fromString($value));
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $identifier;
    }

    /**
     * {@inheritdoc}
     *
     * @param EntityId $value
     * @param AbstractPlatform $platform
     *
     * @return string
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof EntityId) {
            return (string) $value;
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return static::NAME;
    }
}
