<?php
declare(strict_types=1);

/* this is a string of functions that php scoper should not prefix */
/* it must consist of all global functions outside of php scopers folder (like native wp functions) */
/* globally declared helpers that are hotloaded via composer.json must also be included! */
/* globally used helpers of your dependencies that are hotloaded must NOT be included! */
$functions = [
    /* globally functions that the plugin provides must not be prefixed */
    'helpers' => [
        'gtbabel_current_lng',
        'gtbabel_source_lng',
        'gtbabel_referer_lng',
        'gtbabel_language_label',
        'gtbabel_languages',
        'gtbabel_default_language_codes',
        'gtbabel_default_languages',
        'gtbabel_default_settings',
        'gtbabel_languagepicker',
        'gtbabel__',
        'ICL_LANGUAGE_CODE'
    ],
    /* native wp functions must not be prefixed (https://codex.wordpress.org/Function_Reference, https://github.com/humbug/php-scoper/issues/303, https://github.com/snicco/php-scoper-wordpress-excludes/issues/3) */
    'wordpress' => array_merge(
        json_decode( file_get_contents( 'https://raw.githubusercontent.com/snicco/php-scoper-wordpress-excludes/master/generated/exclude-wordpress-classes.json' ), true ),
        json_decode( file_get_contents( 'https://raw.githubusercontent.com/snicco/php-scoper-wordpress-excludes/master/generated/exclude-wordpress-functions.json' ), true ),
        json_decode( file_get_contents( 'https://raw.githubusercontent.com/snicco/php-scoper-wordpress-excludes/master/generated/exclude-wordpress-constants.json' ), true )
    )
];

return [
    'prefix' => 'ScopedGtbabel',
    'expose-global-functions' => false,
    'expose-global-constants' => false,
    'expose-global-classes' => false,
    'patchers' => [
        function (string $filePath, string $prefix, string $content) use ($functions): string {
            // remove prefix
            foreach ($functions as $functions__value) {
                foreach ($functions__value as $functions__value__value) {
                    $content = str_replace(
                        '\\' . $prefix . '\\' . $functions__value__value,
                        '\\' . $functions__value__value,
                        $content
                    ); // "\PREFIX\foo()", or "foo extends nativeClass"
                    $content = str_replace(
                        $prefix . '\\\\' . $functions__value__value,
                        $functions__value__value,
                        $content
                    ); // "if( function_exists('PREFIX\\foo') )"
                }
            }
            // remove the namespace from file that define global functions that should be provided outside
            // don't use "exclude-files" here, because it could be the case, that global functions are mixed with prefixed ones
            if (strpos($filePath, 'helpers.php') !== false) {
                $content = str_replace('namespace ' . $prefix . ';', '', $content);
            }
            return $content;
        }
    ]
    // this is not needed anymore
    /*
    'whitelist' => [
        'GtbabelWordPress\*', // all global/native/class based functions in the wordpress plugin class (you must add a namespace "namespace GtbabelWordPress;" inside the file before!)
        'gtbabel\core\*', // all global/native/class based functions in the main wordpress class
    ],
    'exclude-files' => [
        'uninstall.php', // the uninstall file
        'helpers.php', // all hotloaded global functions by the composer package itself
        'vendor/vielhuber/stringhelper/stringhelper.php', // all libraries with global functions that are hotloaded
    ],
    // all global functions/classes should NOT be prefixed
    'exclude-files' => [
        //'helpers.php', // all hotloaded global functions by the composer package itself should not get a namespace(!)
        //'vendor/vielhuber/stringhelper/stringhelper.php', // all dependencies with global functions that are hotloaded and used should not get a namespace(!)
    ],
    */
];
