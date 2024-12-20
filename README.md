# Laravel Package Skeleton

This is a package skeleton for Laravel that I'm using as a starting point to create my own packages.

## Installation

You can install the package using Composer:

```bash
composer require eleazarbr/laravel-package-skeleton
```

## Usage

After installing the package, you can use it in your Laravel application. Here is an example of how to do it:

```php
use Eresendez\LaravelPackageSkeleton\ExampleClass;

$example = new ExampleClass();
echo $example->sayHello();
```

## Configuration

If you need to configure the package, you can publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="Eresendez\LaravelPackageSkeleton\ServiceProvider"
```

This will create a configuration file in `config/laravel-package-skeleton.php` where you can adjust the options according to your needs.

## Contributing

If you want to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Make your changes and commit them (`git commit -am 'Add new feature'`).
4. Push your changes (`git push origin feature/new-feature`).
5. Open a Pull Request.

## License

This project is licensed under the [MIT License](LICENSE).

## Credits

This package was developed by [Eleazar Resendez](https://github.com/eleazarbr).