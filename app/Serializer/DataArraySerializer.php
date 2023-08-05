<?php

namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class DataArraySerializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param  string  $resourceKey
     */
    public function collection(?string $resourceKey, array $data): array
    {
        return $data;
    }

    /**
     * Serialize an item.
     *
     * @param  string  $resourceKey
     */
    public function item(?string $resourceKey, array $data): array
    {
        return $data;
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null(): ?array
    {
        return [];
    }
}
