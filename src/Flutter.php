<?php

declare(strict_types=1);

namespace Laravilt\Flutter;

use Laravilt\Schemas\Schema;

class Flutter extends Schema
{
    protected array $data = [];

    /**
     * Alias for components() to match Form/InfoList pattern.
     */
    public function schema(array $schema): static
    {
        return $this->components($schema);
    }

    /**
     * Get the schema components.
     */
    public function getSchema(): array
    {
        return $this->components;
    }

    /**
     * Fill the Flutter with data from a record.
     */
    public function fill(mixed $record): static
    {
        $this->data = $record;

        foreach ($this->components as $component) {
            $name = $component->getName();
            if (method_exists($component, 'state')) {
                $value = is_array($record) ? ($record[$name] ?? null) : ($record->{$name} ?? null);
                $component->state($value);
            }
        }

        return $this;
    }

    /**
     * Transform to Flutter-compatible array (camelCase keys).
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->components as $component) {
            $name = $component->getName();
            $value = is_array($this->data) ? ($this->data[$name] ?? null) : ($this->data->{$name} ?? null);

            // Apply any transformations from the component
            if (method_exists($component, 'transform')) {
                $value = $component->transform($value);
            }

            // Convert snake_case to camelCase for Flutter
            $camelKey = lcfirst(str_replace('_', '', ucwords($name, '_')));
            $result[$camelKey] = $value;
        }

        return $result;
    }

    /**
     * Convert to Inertia props format.
     */
    public function toInertiaProps(): array
    {
        return $this->toArray();
    }

    /**
     * Convert to Flutter props (same as toArray for Flutter).
     */
    public function toFlutterProps(): array
    {
        return $this->toArray();
    }
}
