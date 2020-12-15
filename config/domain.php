<?php

return [
  'env_stub' => '.env',
  'storage_dirs' => [
    'app' => [
      'public' => [
          'driver' => 'local',
          'root' => storage_path('app/public'),
          'url' => env('APP_URL').'/storage'.env('APP_PUBLIC_STORAGE'),
          'visibility' => 'public',
      ],
    ],
    'framework' => [
      'cache' => [
      ],
      'testing' => [
      ],
      'sessions' => [
      ],
      'views' => [
      ],
    ],
    'logs' => [
    ],
  ],
  'domains' => [
    'l1.local' => 'l1.local',
    'l2.local' => 'l2.local',
  ],
 ];
