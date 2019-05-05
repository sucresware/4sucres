<?php

return [
    'logo' => '/vendor/devdojo/chatter/assets/images/logo-light.png',
    'security' => [
        'limit_time_between_posts' => true, //
        'time_between_posts'       => 1, // In minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Chatter Editor
    |--------------------------------------------------------------------------
    |
    | You may wish to choose between a couple different editors. At the moment
    | The following editors are supported:
    |   - tinymce    (https://www.tinymce.com/)
    |   - simplemde  (https://simplemde.com/)
    |   - trumbowyg  (https://alex-d.github.io/Trumbowyg/) - requires jQuery >= 1.8
    |
    */

    'editor' => 'tinymce',

    'tinymce' => [
        'toolbar' => 'bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
        'plugins' => 'link, image',
    ],

    'order_by' => [
        'posts' => [
            'order' => 'created_at',
            'by' => 'ASC'
        ],
        'discussions' => [
            'order' => 'last_reply_at',
            'by' => 'DESC'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    |
    | The following are settings that you can use to modify the email settings
    |   - enabled (if you would like to enable or disable email notifications)
    |   - view (the email view sent) $discussion var is passed to view
    |   -
    |
    */

    'email' => [
        'enabled' => false,
        'view'    => 'chatter::email',
    ],

    /*
    |--------------------------------------------------------------------------
    | Use Soft Deletes
    |--------------------------------------------------------------------------
    |
    | Setting this to true will mean when a post gets deleted the `deleted_at`
    | date gets set but the actual row in the database does not get deleted.
    | This is useful for forum moderation and history retention
    |
    */

    'soft_deletes' => false,

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | These are the pagination settings for your forum. Specify how many number
    | of results you want to show per page.
    |
    */

    'paginate' => [
        'num_of_results' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Show missing fields to users in forms
    |--------------------------------------------------------------------------
    |
    | This usually has to be active to show the users what they are missing
    | unless you want to manage by your own system in the master template
    |
    */

    'errors' => true,

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | Configure the middleware applied to specific routes across Chatter. This
    | gives you full control over middleware throughout your application. You
    | can allow public access to everything or limit to specific routes.
    |
    | Authentication is enforced on create, store, edit, update, destroy routes,
    | no need to add 'auth' to these routes.
    |
    */

    'middleware' => [
        'global'     => ['web'],
        'home'       => [],
        'discussion' => [
            'index'   => [],
            'show'    => [],
            'create'  => [],
            'store'   => [],
            'destroy' => [],
            'edit'    => [],
            'update'  => [],
        ],
        'post' => [
            'index'   => [],
            'show'    => [],
            'create'  => [],
            'store'   => [],
            'destroy' => [],
            'edit'    => [],
            'update'  => [],
        ],
        'category' => [
            'show' => [],
        ],
    ],
];
