<?php

return [

    /*
     * Specify the route that your docker health check will call
     */
    'route' => '/docker-health-check',

    /*
     * Temporary file name
     */
    'tempFile' => '.docker-health-check',

    /*
     * Artisan commands to run
     */
    'commands' => [
        'view:clear',
        'route:clear',
        'cache:clear',
    ],

];