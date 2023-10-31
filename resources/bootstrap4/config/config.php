<?php

return [
    /**
     * The default icon to use when no icon is defined or able to be determined.
     *
     * Note: When using Bootstrap, it is recommended to add the `fa-fw` class so the icons are
     * all the same width as well as the `mr-2` class to add a nice space after the icon.
     *
     * Note: An individual message can override this value if needed.
     */
    'icon' => '<i class="fas fa-fw fa-info mr-2"></i>',

    /**
     * The default class to use when an unknown type is used
     *
     * This shouldn't be all of the class values, but just the dynamic ones.
     *
     * Example: `info` for Bootstrap or `bg-blue-500 text-white` for default Laravel 8 (Tailwind v2)
     *
     * Note: When using Tailwind, you should also pass the text color.
     */
    'class' => 'info',

    /**
     * Whether or not flash messages should show an icon by default
     *
     * Note: An individual message can override this value if needed.
     */
    'showIcon' => true,

    /**
     * Whether or not flash messages should show a title by default
     *
     * Note: An individual message can override this value if needed.
     */
    'showTitle' => true,

    /**
     * Whether or not flash messages are dismissable by default
     *
     * Note: An individual message can override this value if needed.
     */
    'dismissable' => true,

    /**
     * Define an icon to use for the particular types you want
     *
     * You can add whatever you want, it just has to match up to the types you are using.
     *
     * Note: When using Bootstrap, it is recommended to add the `fa-fw` class so the icons are
     * all the same width as well as the `mr-2` class to add a nice space after the icon.
     */
    'typeToIconMap' => [
        'error' => '<i class="fas fa-fw fa-ban mr-2"></i>',
        'success' => '<i class="fas fa-fw fa-check mr-2"></i>',
        'warning' => '<i class="fas fa-fw fa-exclamation-triangle mr-2"></i>',
        'info' => '<i class="fas fa-fw fa-info mr-2"></i>',
    ],

    /**
     * Define the class(es) to use for the particular types you want
     *
     * You can add whatever you want, it just has to match up to the types you are using.
     *
     * Note: For Bootstrap, the type's class must come first (ie: success, danger) so it can be
     * appended to `alert-` to generate `alert-danger`. If you don't, you could get
     * `alert-fade show danger`, and that will not work.
     */
    'typeToClassMap' => [
        'error' => 'danger fade show',
        'success' => 'success fade show',
        'warning' => 'warning fade show',
        'info' => 'info fade show',
    ],

    /**
     * A note on the "force" options below:
     *
     * The "force" options allow you to enforce global control in the event that some individual
     * messages are configured differently throughout your app.
     *
     * They SHOULD all be set to false and you SHOULD just be relying on the regular options above.
     * However, I wanted to provide people with a way to override for a rare situation that I didn't
     * predict. Doing that, and the way the config is loaded, means individual messages can override
     * these "force" settings by passing them into their own config as well. Resulting in the ability
     * for an override to be overrode. It can get hairy and lead to unexpected results. Do yourself a
     * favor and search through the code and fix/configure the messages correctly instead.
     *
     * You can do it, but you have been warned.
     */

    'forceIcon' => false,

    'forceTitle' => false,

    'forceDismissable' => false,
];
