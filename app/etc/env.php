<?php
return [
  'backend' => [
    'frontName' => 'admin'
  ],
  'crypt' => [
    'key' => '2ae78030286fbcd88440314429fcdbb3'
  ],
  'db' => [
    'table_prefix' => '',
    'connection' => [
      'default' => [
        'host' => 'localhost',
        'dbname' => 'magento',
        'username' => 'root',
        'password' => '123123',
        'active' => '1',
        'profiler' => [
          'class' => '\\Magento\\Framework\\DB\\Profiler',
          'enabled' => true
        ]
      ]
    ]
  ],
  'resource' => [
    'default_setup' => [
      'connection' => 'default'
    ]
  ],
  'x-frame-options' => 'SAMEORIGIN',
  'MAGE_MODE' => 'default',
  'session' => [
    'save' => 'files'
  ],
  'cache_types' => [
    'config' => 0,
    'layout' => 0,
    'block_html' => 0,
    'collections' => 0,
    'reflection' => 0,
    'db_ddl' => 0,
    'eav' => 0,
    'customer_notification' => 0,
    'config_integration' => 0,
    'config_integration_api' => 0,
    'full_page' => 0,
    'translate' => 0,
    'config_webservice' => 0
  ],
  'install' => [
    'date' => 'Tue, 26 Jun 2018 14:22:51 +0000'
  ]
];
