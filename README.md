# Laravilt Flutter

Flutter widget generation and serialization for Laravilt Resources.

## Installation

```bash
composer require laravilt/flutter
```

## Overview

The Flutter package enables automatic Flutter widget generation from Laravilt Resources, providing seamless integration between your Laravel backend and Flutter mobile applications.

## Features

- Automatic Flutter widget generation from Resources
- Dart/Flutter serialization with type safety
- Field-level control over mobile UI components
- Support for complex widget structures
- Form validation mapping
- State management integration
- Flutter widget code generation

## Usage

### Basic Flutter Resource

```php
use Laravilt\Flutter\Flutter;
use Laravilt\Flutter\Components\FlutterField;

class UserFlutter extends Flutter
{
    public function fields(): array
    {
        return [
            FlutterField::make('id'),
            FlutterField::make('name')
                ->widget('TextField')
                ->validator('required|min:3'),
            FlutterField::make('email')
                ->widget('EmailField')
                ->validator('required|email'),
            FlutterField::make('avatar')
                ->widget('CircleAvatar')
                ->computed(fn ($record) => $record->getAvatar()),
        ];
    }
}
```

### Field Configuration

```php
FlutterField::make('name')
    ->widget('TextField')
    ->hint('Enter your full name')
    ->validator('required|min:3');

FlutterField::make('birthdate')
    ->widget('DatePicker')
    ->format('yyyy-MM-dd');

FlutterField::make('posts')
    ->widget('ListView')
    ->relationship('posts')
    ->nested(PostFlutter::class);
```

### Serialization

```php
// Single record
$user = User::find(1);
$flutterData = UserFlutter::make($user)->toArray();

// Collection
$users = User::all();
$flutterData = UserFlutter::collection($users)->toArray();
```

### Widget Generation

```php
// Generate Dart model
$dartModel = UserFlutter::make()->generateDartModel();

// Generate Flutter widgets
$flutterWidgets = UserFlutter::make()->generateWidgets();
```

## Testing

```bash
composer test              # Run tests
composer test:coverage     # With coverage
composer test:types        # PHPStan analysis
composer test:style        # Code style check
composer format            # Auto-fix code style
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information.

## Contributing

Please see [CONTRIBUTING](../../CONTRIBUTING.md) for details.

## Security

Please review [SECURITY](SECURITY.md) for security issues.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
