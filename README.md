![banner](screenshots/banner.png)
# Nova Mail

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/nova-mail.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/nova-mail)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/nova-mail.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/nova-mail)

This package contains a Nova action that provides a mail sending form for any resource to easily send email. It also includes automated mail sending based on Eloquent Model events/attribute changes.

![screenshot of the send mail action modal](screenshots/send-mail-modal-empty.png)

![screenshot of the send mail action modal with template selected](screenshots/send-mail-modal-template-selected.png)

![screenshot of mail template model events](screenshots/mail-template-model-events.png)

## Requirements

This Nova package requires Nova 4.0 or higher. If you are using a Nova version < 4.0, then you'll want to use [v1.0.4](https://github.com/kirschbaum-development/nova-mail/tree/1.0.4) (no longer updated).

Using the mail delay feature requires a queue driver other than sync. If you are using the Amazon SQS queue service, the maximum delay time is 15 minutes.

## Installation

You can install this package in a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require kirschbaum-development/nova-mail
```

Next, we need to run migrations. Auto-discovery of this package's service provider helps with that!

```bash
php artisan migrate
```

And lastly, any model that you want to send mail needs the `Mailable` trait added to it. The model should have a compliant email column. You also need to implement the abstract method provided by the `Mailable` trait, like shown below. You should customize this if your email column name is different:

```php
use KirschbaumDevelopment\NovaMail\Traits\Mailable;

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

There is a single action (`SendMail`) and two resources (`NovaMailTemplate` and `NovaSentMail`) that ship with this package. Internally the `SendMail` action uses a custom Nova field to display the inline mail sending form.

### SendMail action

The `SendMail` action inserts a mail form directly into a Nova action modal. This action allows you to quickly send an email directly to one or more resources.

Simply add the `KirschbaumDevelopment\NovaMail\Actions\SendMail` action to your Nova resource:

```php
namespace App\Nova;

use KirschbaumDevelopment\NovaMail\Actions\SendMail;

class User extends Resource
{
    // ...

    public function actions(Request $request)
    {
        return [
            // ...

            new SendMail,
        ];
    }
}
```

Now you can send emails from the action called "Send Mail" on your resource!

You can also delay any outgoing email by setting the delay in minutes property on the template. Like subject and body, you can override the mail delay specified in the template when you send mail.

### Trigger Mail on Model Events

A `MailTemplate` can be configured to respond to Eloquent Model events, or a value change of a specified column. For example, a mail template informing your users of their account status could be sent when the `active` column on your `User` model is updated:

![screenshot of the account status mail template](screenshots/model-event-account-status-change.png)

You can even have separate Model Events for both "on" an "off"!

![screenshot of the account status with value mail template](screenshots/model-event-account-status-change-with-value.png)

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

![screenshot of the create mail template](screenshots/create-mail-template.png)

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

![screenshot of the sent mail index](screenshots/nova-sent-mail.png)

## Resource Customization

In case you need to customize the `Nova Resources` that you're using in your application, for instance, to add filters, cards or add fields. You can change the default set of classes.
First, you'll need to override the array of `Resources` found in the config file (If you haven't published a config file yet please see the **Installation** section):

```php
    /*
    |--------------------------------------------------------------------------
    | Default Resources
    |--------------------------------------------------------------------------
    |
    | This determines which Nova Resources you're using
    | You can change it as you wish
    |
    */
    'default_resources' => [
        'nova_mail_event' => App\Nova\YourNovaMailEventResource::class,
        'nova_mail_template' => App\Nova\YourNovaMailTemplateResource::class,
        'nova_sent_mail' => App\Nova\YourNovaSentMailResource::class,
    ],
```

After that you can `extends` the default `Resource Class` and add your custom code like this:

```php
use KirschbaumDevelopment\NovaMail\Nova\NovaSentMail;

class YourNovaSentMailResource extends NovaSentMail
{
    public function cards(Request $request)
    {
        return [
            // Your custom code...
        ];
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email adam@kirschbaumdevelopment.com or nathan@kirschbaumdevelopment.com instead of using the issue tracker.

## Credits

- [Adam Parker](https://github.com/adammparker)
- [Brandon Ferens](https://github.com/brandonferens)
- [Justin Seliga](https://github.com/jrseliga)
- [Belisar Hoxholli](https://github.com/belisarh)

## Sponsorship

Development of this package is sponsored by Kirschbaum Development Group, a developer driven company focused on problem solving, team building, and community. Learn more [about us](https://kirschbaumdevelopment.com) or [join us](https://careers.kirschbaumdevelopment.com)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
