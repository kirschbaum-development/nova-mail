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
    ],
];
