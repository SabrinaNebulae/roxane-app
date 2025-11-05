<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/rsync.php';

// Environment
$env = $_SERVER['CI_COMMIT_REF_NAME'] === 'master' ? 'PROD' : 'STAGING';

$envConfig = [
    'host' => $_SERVER[$env . '_SSH_HOST'],
    'port' => $_SERVER[$env . '_SSH_PORT'] ?? 22,
    'user' => $_SERVER[$env . '_SSH_USER'],
    'path' => $_SERVER[$env . '_SSH_PATH'],
    'repository' => $_SERVER['CI_REPOSITORY_URL'],
];

// GLOBAL
set('repository', $envConfig['repository']);
set('keep_releases', 3);
set('bin/php', '/usr/bin/php8.3');
set('bin/composer', '{{bin/php}} /usr/local/bin/composer');
set('composer_options', '--no-dev --optimize-autoloader --no-interaction --prefer-dist');
set('rsync_src', __DIR__);
set('rsync_dest', '{{release_path}}');
set('rsync', [
    'exclude' => [
        '.git',
        'node_modules',
        'vendor',
        '.env',
        '.gitlab-ci.yml',
        'deploy.php',
    ],
    'flags' => 'rz',
    'options' => ['delete'],
]);

// HOSTS
host($envConfig['host'])
    ->setPort($envConfig['port'])
    ->set('remote_user', $envConfig['user'])
    ->set('deploy_path', $envConfig['path']);

// TASKS
task('deploy:vendors', function () {
    run('cd {{release_path}} && {{bin/composer}} install {{composer_options}}');
});

task('build:assets', function () {
    run('cd {{release_path}} && npm ci && npm run build');
});

task('artisan:storage:link', artisan('storage:link'));
task('artisan:cache:clear', artisan('cache:clear'));
task('artisan:config:clear', artisan('config:clear'));
task('artisan:migrate', artisan('migrate --force'));

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'build:assets',
    'artisan:storage:link',
    'artisan:config:clear',
    'artisan:cache:clear',
    'artisan:migrate',
    'deploy:publish',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
