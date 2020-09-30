<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mail Template Disk
    |--------------------------------------------------------------------------
    |
    | You can specify the disk (from config/filesystems.php) that you'd like
    | temporary email files used by the SendMail mailable to be created.
    |
    */

    'compiled_mail_disk' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Mail Template Path
    |--------------------------------------------------------------------------
    |
    | You can specify the path that you'd like temporary email
    | files used by the SendMail mailable to be created.
    |
    */

    'compiled_mail_path' => 'views/emails',

    /*
    |--------------------------------------------------------------------------
    | Show Resources
    |--------------------------------------------------------------------------
    |
    | This deterimines if the provided Nova resources
    | are displayed in the Nova navigation menu.
    |
    */

    'show_resources' => [
        'nova_sent_mail' => true,
        'nova_mail_template' => true,
        'nova_mail_event' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Classes for dynamic event/column listening
    |--------------------------------------------------------------------------
    |
    | Here you can specify which classes can have dynamic
    | listeners for sending Nova Mail Templates.
    |
    | Ex: [User::class]
    |
    | Note: These classes must use the Mailable trait and
    |       implement the abstract method getEmailField.
    ]
    */

    'eventables' => [],
];
