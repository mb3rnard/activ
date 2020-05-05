<?php

namespace App\Infra\Serializer\Normalizer;

use App\Domain\Activity\Activity;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ActivityNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => (string) $object->getId(),
            'name' => $object->getName(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Activity;
    }
}
