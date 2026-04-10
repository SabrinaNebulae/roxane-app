<?php

return [
    'enabled' => env('PREPROD', false),
    'admin_mails' => env('PREPROD_ADMIN_MAILS', ''),
    'test_mails' => env('PREPROD_TEST_MAILS', ''),
];
