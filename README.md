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

And lastly, any model that you want to send mail needs the `Mailable` trait added to it. The model should have a compliant email column. You also need to implement the abstract method provided by the `Mailable` trait, like shown below. You should customize this if your email field is different:

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

There is a single component (`Mailer`) and two resources (`NovaMailTemplate` and `NovaSentMail`) that ship with this package.

### Mailer component

The `Mailer` component is a resource tool that allows you to insert a mail form panel directly onto any Nova resource. This panel allows you to quickly send an email directly to a resource.

Simply add the `KirschbaumDevelopment\NovaMail\Mailer` resource tool in your Nova resource:

**_NOTE:_** You must pass the `Resource` (i.e. `$this`) to the `Mailer` component like shown below.

```php
namespace App\Nova;

use KirschbaumDevelopment\NovaMail\Mailer;

class User extends Resource
{
    // ...

    public function fields(Request $request)
    {
        return [
            // ...

            new Mailer($this),

            // ...
        ];
    }
}
```

Now you can send emails from the detail view of any resource you've attached the `NovaMail` to!

### Mail Template Usage/Caveats

The `NovaMailTemplate` resource allows you to create re-usable custom templates for sending email. It works by taking your specified template (or over-ridden template content) and building a temporary blade file (the Blade file can be saved permantely via a configuration option). This blade file is then used in the typical Laravel fashion to send the email.

The final content provided when the user clicks the "Send Mail" button is parsed as markdown and makes no assumptions about newlines or any other formatting for that matter. For example, if you were to use the built in mail message component provided by Laravel for markdown emails you could create a template like the following:

```
@component('mail::message')
Hello {{ $name }},

Visit this link when you have a moment:

[https://github.com/kirschbaum-development/nova-mail](https://github.com/kirschbaum-development/nova-mail)

Let me know if you have any questions.

@include('path.to.footer')
@endcomponent
```

### Sent Mail Usage

The `NovaSentMail` resource can be added as a relationship field to any `Resource` that has the `Mailable` trait defined on it's corresponding model. This gives you direct access to the history of emails sent from that `Resource`:

```php
namespace App\Nova;

use Laravel\Nova\Fields\HasMany;
use KirschbaumDevelopment\NovaMail\Nova\NovaSentMail;

class User extends Resource
{
    // ...

    public function fields(Request $request)
    {
        return [
            // ...

            HasMany::make('Sent Mail', 'mails', NovaSentMail::class),

            // ...
        ];
    }
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