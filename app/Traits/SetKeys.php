<?php

namespace App\Traits;

trait SetKeys
{
    /**
     * @param array|object $filterKeys DTO с ключами фильтров
     * @return string
     */
    public function setKeys(array|object $filterKeys): string
    {
        $entityValue = $this->value ?? '';

        $parameters = $this->getParameters($filterKeys);

        if (empty($parameters)) {
            return $this->value;
        }

        $keys = array_map(
            function ($value, $key) {
                if (is_object($value) || is_array($value)) {
                    $value = $this->setKeys($value);
                }

                return "$key:$value";
            },

            $parameters,
            array_keys($parameters)
        );

        return "{$entityValue}_" . implode('-', $keys);
    }

    private function getParameters(array|object $filterKeys): array
    {
        if (is_array($filterKeys)) {
            return $filterKeys;
        }

        if (enum_exists($filterKeys::class)) {
            return [
                'value' => $filterKeys->value
            ];
        }

        return array_filter(get_object_vars($filterKeys));
    }
}
