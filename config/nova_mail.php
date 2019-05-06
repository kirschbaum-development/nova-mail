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
    | Default Subject
    |--------------------------------------------------------------------------
    |
    | This is the global default subject if the mail template does not provide
    | one, or one is not provided when a mail is sent from a resource.
    |
    */

    'default_subject' => 'Hey there!',

    /*
    |--------------------------------------------------------------------------
    | Default From
    |--------------------------------------------------------------------------
    |
    | This is the global default from if the mail template does not provide
    | one, or one is not provided when a mail is sent from a resource.
    |
    */

    'default_from' => 'admin@admin.com',

    /*
    |--------------------------------------------------------------------------
    | Keep Compiled File
    |--------------------------------------------------------------------------
    |
    | This deterimines if the compiled blade file used for sending the mail
    | is kept on the file system after the mail has been delivered.
    |
    */

    'keep_compiled_file' => true,
];
