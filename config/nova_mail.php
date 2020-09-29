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
    | Keep Compiled File
    |--------------------------------------------------------------------------
    |
    | This deterimines if the compiled blade file used for sending the mail
    | is kept on the file system after the mail has been delivered.
    |
    */

    'keep_compiled_file' => false,

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
    | Model Paths for Eventing Auto-discover
    |--------------------------------------------------------------------------
    |
    | Here you can specific paths relative to your main app directory. Two
    | defaults are already set as 'app' and 'app/Models'. If your model
    | classes exist in a different directory, you can load them here.
    |
    | Example: ['app/MyModels']
    ]
    */

    'model_paths' => [],
    'excluded_paths' => [],

    /*
    |--------------------------------------------------------------------------
    | Excluded Models from Auto-discover
    |--------------------------------------------------------------------------
    |
    | Here you can specify certain models that you may not want discovered
    | in the auto-discover paths. Occasionally a model will need to use
    | the Mailable trait, but the mail must be sent manually instead.
    |
    | Example: [App\User::class]
    ]
    */

    'excluded_models' => [],
];
