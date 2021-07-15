<?php

namespace ArielMejiaDev\JsonApiAuth\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json-api-auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Json Api Authentication controllers and routes.';

    public function __construct()
    {
        parent::__construct();

        if (file_exists(config_path('json-api-auth.php')))
        {
            $this->setHidden(true);
        }
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->appHasSanctum() && !$this->appHasPassport()) {
            $this->output->error('The package requires some official package to handle api tokens.');
            $this->warn('You can choose between Laravel Sanctum (your app would be consumed by mobile & js apps) or Laravel Passport (your app would be consumed by third party apps with oauth).');
            $this->info('For Laravel sanctum you can run: composer require laravel/sanctum');
            $this->info('For Laravel passport you can run: composer require laravel/passport');
            return null;
        }

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Http/Controllers/JsonApiAuth', app_path('Http/Controllers/JsonApiAuth'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Http/Requests/JsonApiAuth', app_path('Http/Requests/JsonApiAuth'));

        // Notifications...
        (new Filesystem)->ensureDirectoryExists(app_path('Notifications/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Notifications/JsonApiAuth', app_path('Notifications/JsonApiAuth'));

        // Translate files...
        (new Filesystem)->ensureDirectoryExists(resource_path('lang'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/lang', resource_path('lang/en'));

        // Tests...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));

        // Routes...
        copy(__DIR__.'/../../stubs/routes/api.php', base_path('routes/api.php'));
        if($this->appHasSanctum()) {
            copy(__DIR__ . '/../../stubs/routes/auth/sanctum.php', base_path('routes/json-api-auth.php'));
        }

        if($this->appHasPassport()) {
            copy(__DIR__ . '/../../stubs/routes/auth/passport.php', base_path('routes/json-api-auth.php'));
        }

        // Config...
        copy(__DIR__.'/../../stubs/config/config.php', base_path('config/json-api-auth.php'));

        $this->output->success('Json Api Authentication scaffolding installed successfully here the routes of the package:');

        $this->createRoutesTable();
    }

    protected function appHasSanctum(): bool
    {
        return class_exists('Laravel\Sanctum\Sanctum');
    }

    protected function appHasPassport(): bool
    {
        return class_exists('Laravel\Passport\Passport');
    }


    /**
     * At command runtime the routes files are not available yet, so its necessary to build it manually
     */
    public function createRoutesTable()
    {
        $headers = ['METHOD', 'URI', 'NAME'];

        $routes = [
            [
                'method' => 'POST',
                'uri' => 'api/confirm-password',
                'name' => 'json-api-auth.password.confirm',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/email/verification-notification',
                'name' => 'json-api-auth.verification.send',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/forgot-password',
                'name' => 'json-api-auth.password.email',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/login',
                'name' => 'json-api-auth.login',
            ],
            [
                'method' => 'GET|HEAD',
                'uri' => 'api/logout',
                'name' => 'json-api-auth.logout',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/register',
                'name' => 'json-api-auth.register',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/reset-password',
                'name' => 'json-api-auth.password.update',
            ],
            [
                'method' => 'GET|HEAD',
                'uri' => 'api/verify-email/{id}/{hash}',
                'name' => 'json-api-auth.verification.verify',
            ],
        ];

        $this->table($headers, $routes);
    }
}
