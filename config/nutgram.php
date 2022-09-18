<?php

return [
    // The Telegram BOT api token
    'token' => env('TELEGRAM_TOKEN'),

    // if the webhook mode must validate the incoming IP range is from a telegram server
    'safe_mode' => env('APP_ENV', 'local') === 'production',

    // Extra or specific configurations
    'config' => [
        'split_long_messages' => true,
    ],

    // Set if the service provider should automatically load
    // handlers from /routes/telegram.php
    'routes' => true,

    // Enable or disable Nutgram mixins
    'mixins' => true,

    // Path to save files generated by nutgram:make command
    'namespace' => app_path('Telegram'),
];
