> We need your support to maintain this package. 💖 https://github.com/sponsors/ueberdosis

# Laravel Docker Health Check

A simple package that makes it easier to work with Laravel and Docker in production.

[![Sponsor](https://img.shields.io/static/v1?label=Sponsor&message=%E2%9D%A4&logo=GitHub)](https://github.com/sponsors/ueberdosis)

## Installation

Install it with composer:

```bash
# Add private repo
composer config repositories.laravel-docker-health-check vcs git@github.com:ueberdosis/laravel-docker-health-check.git

# Require it
composer require ueberdosis/laravel-docker-health-check
```

Add the Middleware to your `app/Http/Kernel.php`:

```php
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // ...
        Ueberdosis\DockerHealthCheck\Middleware\ClearCacheOnInitialRequest::class,
    ];
    
    // ...
}
```

Update your health check script to curl the newly registered route `/docker-health-check`. The following is an example health check script, please update your own implementation:

```bash
#!/usr/bin/env bash
set -e

if [ $(curl -o /dev/null -L -s -w "%{http_code}\n" http://localhost/docker-health-check) = "200" ]; then
    exit 0
else
    exit 1
fi    
```

## What problem is this package solving?

When using Laravel with Docker in production you would normally write a huge entrypoint script that runs migrations, clears caches and so on. But clearing caches in this entrypoint script doesn't work well. Why?

Well, the orchestrator waits for the Laravel container to become healthy before directing actual traffic to it. So when you update your stack, the old container will handle all the traffic at the moment when you call `php artisan view:clear` in your entrypoint up to the moment when the new container is healthy. When traffic hits the site in that moment, the cache will be rebuilt in the old container.

This is a huge pain on big dockerized Laravel apps. This package will clear caches on the first request to a new container by using a temporary file in the app root.

And it conveniently registers a nice `/docker-health-check` route for you that returns a response with status code 200 for your health check script.

## License

MIT
