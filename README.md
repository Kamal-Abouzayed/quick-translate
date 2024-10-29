# QuickTranslate

QuickTranslate is a Laravel package that enables easy translation of words into multiple languages using Google Translate. It simplifies the process of managing translations for your application.

## Table of Contents

- [Installation](#installation)
- [Service Provider](#register-the-service-provider)
- [Publish the Configuration](#publish-the-configuration)
- [Usage](#usage)
- [License](#license)

## Installation

To install the package, run the following command in your Laravel project's root directory:

```bash
composer require kamalabouzayed/quicktranslate
```
## Register the Service Provider

If you're using Laravel 5.4 or below, you need to register the service provider in your `config/app.php` file. Add the following line to the `providers` array:

```php
'providers' => [
    // ...
    KamalAbouzayed\QuickTranslate\QuickTranslateServiceProvider::class,
],
```
Starting from Laravel 5.5, package auto-discovery is supported, so you can skip this step.

## Publish the Configuration

To customize the package settings, publish the configuration file by running the following command:

```bash
php artisan vendor:publish --provider="KamalAbouzayed\QuickTranslate\QuickTranslateServiceProvider" --tag=config
```
This command will create a configuration file at `config/quick-translate.php`. You can set the supported locales and the path to the translations file in this config file.

## Example Configuration

Here’s an example configuration you might use:

```php
<?php

return [

    /**
     * Set array of supported locales.
     *
     * @var array
     */
    'locales' => [
        'en',
        'ar',
    ],

    /**
     * Set path to translations file.
     *
     * @var string
     */
    'translationsFile' => storage_path('app/translations.json'),
];
```

## Usage

You can utilize the translation functionality by calling the `translate` function.

## Example 

Here’s how you can translate a word using the package:

```php
<?php

$word = translate('Hello');

echo $word;

// Output: Depends on the current application locale
// ar => مرحبا
// en => Hello
```

## License

This package is licensed under the [MIT license](https://github.com/kamal-abouzayed/quick-translate/blob/main/LICENSE).
