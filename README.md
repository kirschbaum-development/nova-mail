# A mail resource tool for Nova apps

This package contains an inline mail sending form for any resource to easily send email.

## Requirements

This Nova resource tool requires Nova 2.0 or higher.

## Installation

You can install this package in a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require kirschbaum-development/nova-mail
```

Next, we need to run migrations. Auto-discovery of this package's service provider helps with that!

```bash
php artisan migrate
```

And lastly, any model that you want to send mail needs the `Mailable` trait added to it. The model should have a compliant email column. You also need to implement the abstract method provided by the `Mailable` trait, like show below. You should custom this if your email field is different:

```php
use KirschbaumDevelopment\NovaMail\Mailable;

class User extends Model
{
    use Mailable;

    /**
     * Get the name of the email field for the model.
     *
     * @return string
     */
    public function getEmailField(): string
    {
        return 'email';
    }

    // ...
}
```

If you would like to publish the config for this package, run:

```bash
php artisan vendor:publish
```
And choose the provider for this package: `KirschbaumDevelopment\NovaMail\NovaMailServiceProvider`

## Usage

There is a single component (`NovaMail`) and two resources (`MailTemplate` and `Mail`) that ship with this package.

### NovaMail component

The `NovaMail` component is a resource tool that allows you to insert a mail form panel directly onto any Nova resource. This panel allows you to quickly send an email directly to a resource. Previously sent emails show up below the mail form with live updating.

Simply add the `KirschbaumDevelopment\NovaMail\NovaMail` resource tool in your Nova resource:

```php
namespace App\Nova;

use KirschbaumDevelopment\NovaComments\Commenter;

class User extends Resource
{
    // ...

    public function fields(Request $request)
    {
        return [
            // ...

            new NovaMail($this),

            // ...
        ];
    }
}
```

Now you can send emails from the detail view of any resource you've attached the `NovaMail` to!!

### Pagination caveat

Due to an limitation in how Nova paginates results, there is currently no way to set the `perPage` value for the number of comments that will display at a time from a configuration value. Nova's default value is 5 per page. If you would like to set this to a different value, such as 25, we recommend you extend the extend the `Mail` resource and set this value with the follwing code:

```php
use KirschbaumDevelopment\NovaMail\Nova\Mail as NovaMailResource;

class Mail extends NovaMailResource
{
    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email brandon@kirschbaumdevelopment.com or nathan@kirschbaumdevelopment.com instead of using the issue tracker.

## Credits

- [Adam Parker](https://github.com/adammparker)
- [Brandon Ferens](https://github.com/brandonferens)
- [Justin Seliga](https://github.com/jrseliga)

## Sponsorship

Development of this package is sponsored by Kirschbaum Development Group, a developer driven company focused on problem solving, team building, and community. Learn more [about us](https://kirschbaumdevelopment.com) or [join us](https://careers.kirschbaumdevelopment.com)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.