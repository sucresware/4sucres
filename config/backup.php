<?php

return [
    'backup' => [
        'name' => env('APP_NAME', 'laravel-backup'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                    base_path('storage'),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('storage/app/backup'),
                ],
                'follow_links' => false,
            ],
            'databases' => [
                'mysql',
            ],
        ],

        'database_dump_compressor' => Spatie\DbDumper\Compressors\GzipCompressor::class,

        'destination' => [
            'filename_prefix' => '',
            'disks' => ['backup'],
        ],

        'temporary_directory' => storage_path('app/backup-temp'),
    ],

    'notifications' => [
        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class => ['mail', 'slack'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class => ['mail', 'slack'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailed::class => ['mail', 'slack'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessful::class => ['mail', 'slack'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFound::class => ['mail', 'slack'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessful::class => ['mail', 'slack'],
        ],

        'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,

        'mail' => [
            'to' => env('BACKUP_NOTIFICATIONS_MAIL_TO', null),
        ],

        'slack' => [
            'webhook_url' => env('BACKUP_NOTIFICATIONS_SLACK_WEBHOOK_URL', null),
            'channel' => null,
            'username' => null,
            'icon' => null,
        ],
    ],

    'monitor_backups' => [
        [
            'name' => env('APP_NAME', 'laravel-backup'),
            'disks' => ['backup'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    'cleanup' => [
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,
        'default_strategy' => [
            'keep_all_backups_for_days' => 7,
            'keep_daily_backups_for_days' => 16,
            'keep_weekly_backups_for_weeks' => 8,
            'keep_monthly_backups_for_months' => 4,
            'keep_yearly_backups_for_years' => 2,
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
    ],
];
