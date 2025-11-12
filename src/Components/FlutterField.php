<?php

declare(strict_types=1);

namespace Laravilt\Flutter\Components;

use Laravilt\Core\Component;
use Laravilt\Support\Concerns\HasState;

class FlutterField extends Component
{
    use HasState;

    protected ?string $type = null;

    protected bool $nullable = false;

    /**
     * Set the Flutter type (String, int, bool, DateTime, etc.).
     */
    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Mark field as nullable.
     */
    public function nullable(bool $condition = true): static
    {
        $this->nullable = $condition;

        return $this;
    }

    /**
     * Transform the value for Flutter output.
     */
    public function transform(mixed $value): mixed
    {
        if ($value === null && $this->nullable) {
            return null;
        }

        return match ($this->type) {
            'DateTime' => $value?->toIso8601String(),
            'bool' => (bool) $value,
            'int' => (int) $value,
            'double' => (float) $value,
            default => $value,
        };
    }

    protected function getVueComponent(): string
    {
        return 'FlutterField';
    }

    protected function getVueProps(): array
    {
        return [
            'type' => $this->type,
            'nullable' => $this->nullable,
            'value' => $this->getState(),
        ];
    }

    protected function getFlutterWidget(): string
    {
        return 'FlutterField';
    }

    protected function getFlutterWidgetProps(): array
    {
        return [
            'type' => $this->type,
            'nullable' => $this->nullable,
            'value' => $this->getState(),
        ];
    }
}
