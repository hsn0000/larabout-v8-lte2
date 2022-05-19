<?php

return [

    /*
     * The destination path for the javascript file.
     */
    'path' => 'resources/themes/js',

    /*
     * The destination filename for the javascript file.
     */
    'filename' => 'router',

    /*
     * The namespace for the helper functions. By default this will bind them to
     * `window.laroute`.
     */
    'namespace' => 'router',

    /*
     * Generate absolute URLs
     *
     * Set the Application URL in config/app.php
     */
    'absolute' => false,

    /*
     * The Filter Method
     *
     * 'all' => All routes except "'laroute' => false"
     * 'only' => Only "'laroute' => true" routes
     * 'force' => All routes, ignored "laroute" route parameter
     */
    'filter' => 'all',

    /*
     * Controller Namespace
     *
     * Set here your controller namespace (see RouteServiceProvider -> $namespace) for cleaner action calls
     * e.g. 'App\Http\Controllers'
     */
    'action_namespace' => '',

    /*
     * The path to the template `laroute.js` file. This is the file that contains
     * the ported helper Laravel url/route functions and the route data to go
     * with them.
     */
    // 'template' => 'vendor/te7a-houdini/laroute/src/templates/laroute.js',
    'template' => 'resources/themes/js/route-template.js',

    /*
     * Appends a prefix to URLs. By default the prefix is an empty string.
    *
    */
    'prefix' => '',

];
