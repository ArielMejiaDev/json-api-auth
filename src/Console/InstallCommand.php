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

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Http/Controllers/JsonApiAuth', app_path('Http/Controllers/JsonApiAuth'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Http/Requests/JsonApiAuth', app_path('Http/Requests/JsonApiAuth'));

        // Tests...
//        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));

        // Routes...
        copy(__DIR__.'/../../stubs/routes/api.php', base_path('routes/api.php'));
        copy(__DIR__.'/../../stubs/routes/auth.php', base_path('routes/json-api-auth.php'));

        // Config...
        copy(__DIR__.'/../../stubs/config/config.php', base_path('config/json-api-auth.php'));

        $this->info('Json Api Authentication scaffolding installed successfully.');
        $this->comment('You can register a user in ' . config('app.url') . '/api/register');
    }
}
