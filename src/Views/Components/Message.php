<?php

namespace CyberPunkCodes\FlashMessages\Views\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Message extends Component
{
    /**
     * The message array passed from the container component
     *
     * Warning: Do not use this! It is passed from the Container component and is used to configure
     * this component. The data in it will not be accurate due to custom config processing done in
     * this component.
     *
     * @var array|null
     */
    public $messageData;

    /**
     * The type of flash message
     *
     * Example: success, error, warning, info
     * Default: info
     *
     * @var string
     */
    public $type = 'info';

    /**
     * The CSS class for the flash message
     *
     * This is set by the `setClass()` method, which uses the `typeToClassMap` array to choose a
     * class based on the type.
     *
     * The class can be overrode by passing it in the individual message's config array.
     *
     * Note: Bootstrap uses `danger` instead of `error`, so we automatically convert it in the
     * `typeToClassMap`.
     *
     * Example: success, error/danger, warning, info
     * Default: info
     *
     * @var string
     */
    public $class = 'info';

    /**
     * The title of the flash message
     *
     * To set a title for an individual flash message, pass it in the message's config array like:
     * `$config = ['title' => 'This is my title']`
     *
     * If no title is present and `showTitle` is `true` (or `forceTitle` is `true`), the `type`
     * will be used and converted to an uppercased title via `Str::title()`.
     *
     * Example: Success, Error, Warning, Info
     * Default: null
     *
     * @var string
     */
    public $title = null;

    /**
     * The text of the flash message
     *
     * This is the actual message text itself.
     *
     * Example: "The action you took was completed successfully!"
     * Default: null
     *
     * @var string
     */
    public $message = null;

    /**
     * The icon HTML
     *
     * The icons should be defined in your `typeToIconMap` array in your config and
     * will be set by the `setIcon()` method automatically. You shouldn't need to manually
     * set this, but you can if you pass an `icon` key in the `$config` array when creating
     * the flash message.
     *
     * Note: When using Bootstrap, it is recommended to add the `fa-fw` class so the icons are
     * all the same width as well as the `mr-2` class to add a nice space after the icon.
     *
     * Example: `$config = ['icon' => '<i class="icon fa fa-info"></i>']`
     * Default: null
     *
     * @var string
     */
    public $icon = null;

    /**
     * Fallback icon
     *
     * This is an internal holder for a fallback icon. When this class is instantiated, it will copy
     * the default configured `icon` and store it here. This way, if using `forceIcon`, we can still
     * set an icon in the event the original icon value is empty.
     *
     * @var string
     */
    private $_fallbackIcon = null;

    /**
     * Whether or not the flash message alert is dismissable
     *
     * Dismissable alerts allow the user to click an "x" to close them.
     *
     * Default: true
     *
     * @var bool
     */
    public $dismissable = true;

    /**
     * Whether or not to show the title
     *
     * Default: true
     *
     * @var bool
     */
    public $showTitle = true;

    /**
     * Whether or not to show the icon
     *
     * Default: true
     *
     * @var bool
     */
    public $showIcon = true;

    /**
     * Whether or not to always display an icon
     *
     * If the message does not have an icon, the default icon will be used. By default, that icon
     * is `info` unless it has been changed in the `config/flashmessages.php` config file.
     *
     * A message can end up without an icon a few ways. If the value of `icon` in `config/flashmessages.php`
     * is not set (null or empty '') AND there is not a match for the message's `type` defined in the
     * `mapTypeToIcon` array. In this event, the
     *
     * @var bool
     */
    public $forceIcon = false;
    /**
     * Whether or not to always display a title
     *
     * If there is no title set, the `type` will be used and uppercased via `Str::title()`.
     *
     * This value comes from `config/flashmessages.php`, but can be overrode by being passed in the
     * individual message's `$config` array. Override it very sparingly! See the example in this
     * constructor's doc block.
     *
     * Default: false
     *
     * @var bool
     */
    public $forceTitle = false;

    /**
     * Whether or not to always use a dismissable flash message
     *
     * This value comes from `config/flashmessages.php`, but can be overrode by being passed in the
     * individual message's `$config` array. Override it very sparingly! See the example in this
     * constructor's doc block.
     *
     * Default: false
     *
     * @var bool
     */
    public $forceDismissable = false;

    /**
     * The type to icon array map
     *
     * This maps a flash message type (ie: success, error) to an HTML icon. This should
     * be defined in your flashmessages config file (`config/flashmessages.php).
     *
     * Note: When using Bootstrap, it is recommended to add the `fa-fw` class so the icons are
     * all the same width as well as the `mr-2` class to add a nice space after the icon.
     *
     * @var array
     */
    private $typeToIconMap = [
        'error' => '<i class="fas fa-fw fa-ban mr-2"></i>',
        'success' => '<i class="fas fa-fw fa-check mr-2"></i>',
        'warning' => '<i class="fas fa-fw fa-exclamation-triangle mr-2"></i>',
        'info' => '<i class="fas fa-fw fa-info mr-2"></i>',
    ];

    /**
     * The type to class array map
     *
     * This maps a flash message type (ie: success, error) to a CSS class to be used when
     * rendering the flash message.
     *
     * Notice: `error` is mapped to `danger` to be compatible with Bootstrap.
     *
     * @var array
     */
    private $typeToClassMap = [
        'error' => 'danger',
        'success' => 'success',
        'warning' => 'warning',
        'info' => 'info',
    ];

    /**
     * Create a new component instance.
     *
     * Receives an array of messages where a message looks like:
     *
     * ```php
     * $message = [
     *     'type'  => 'success',
     *     'message'  => 'The operation was a success!',
     *     'config => [
     *         // common config options
     *         'title' => 'Custom Title',
     *         'class' => 'custom-classname',           // if you want to use a different class for this message
     *         'icon'  => '<i class="fas fa-taxi"></i>',// if you want to use a different icon for this message
     *
     *         // rare config options
     *         'showIcon'    => true,                   // override the default config values
     *         'showTitle'   => false,                  // override the default config values
     *         'dismissable' => false,                  // override the default config values
     *
     *         // In the VERY RARE event you need to override the "forced" settings (defined in config)
     *         // This allows you to override the override for this individual message itself
     *
     *         // very rare config options
     *         'forceIcon' => false,                    // override `forceIcon` (if enabled in config)
     *         'forceTitle'  => false,                  // override `forceTitle` (if enabled in config)
     *         'forceDismissable'  => false,            // override `forceDismissable` (if enabled in config)
     *     ],
     * ];
     * ```
     *
     * If, for example, `forceDismissable` is set to `true` in the config, and you wanted to show a
     * flash message that was not dismissable. Maybe it's an important warning... Passing
     * `forceDismissable` in the individual message's config array provides you with a way to
     * override the global setting.
     *
     * If, for example, `forceTitle` is set to `true` in the config, and you wanted to show a
     * flash message that did not have a title. Passing `forceTitle` in the individual message's
     * config array provides you with a way to override the global setting.
     *
     * Overriding the overrides should be a VERY RARE use case! So use it very sparingly! Else, it
     * may get hairy :)
     *
     * If `showTitle` is set to `true` and the `title` was not defined or it is empty, a title
     * will be generated using Laravel's helper `Str::title()`.
     *
     *
     * Required `$messageData` params: `type` and `message`
     *
     * @param array $messageData The message array passed from the container component
     *
     * @return void
     */
    public function __construct(array $messageData)
    {
        $this->messageData = $messageData;

        $this->loadDefaultConfig();

        // grab the icon and store it for safe keeping
        $this->_fallbackIcon = $this->icon;

        $this->type = $messageData['type'];
        $this->message = $messageData['message'];

        // set class and icon here so the config passed to the message can override if needed
        $this->setClass();
        $this->setIcon();

        // update the config settings if the individual message passed a `config` array
        $this->loadMessageConfig($messageData);

        // re-evaluate the configuration in case of overrides or mismatches
        $this->postConfig();                    // call this last!
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('flashmessages::components.message');
    }

    /**
     * Prevent overriding certain variables within the default config
     *
     * @param string $key
     *
     * @return bool
     */
    private function isDefaultConfigAllowedToSet($key)
    {
        $blacklist = [
            'messageData', 'title', 'message'
        ];

        return !in_array(strtolower($key), array_map('strtolower', $blacklist));
    }

    /**
     * Prevent overriding certain variables within the individual message's config array
     *
     * @param string $key
     *
     * @return bool
     */
    private function isMessageConfigAllowedToSet($key)
    {
        /**
         * There is no need to set `typeToIconMap` or `typeToClassMap` in the message.
         * You can just define the `icon` or `class` directly...
         */
        $blacklist = [
            'messageData', 'typeToIconMap', 'typeToClassMap'
        ];

        return ! in_array(strtolower($key), array_map('strtolower', $blacklist));
    }

    /**
     * Load the default configuration from `config/flashmessages.php`
     *
     * To publish the config file, run:
     *
     * ```
     * php artisan vendor:publish --provider="CyberPunkCodes\FlashMessages\FlashMessagesProvider" --tag="config"
     * ```
     *
     * If you don't publish the config file, the default config will be used.
     *
     * @return void
     */
    private function loadDefaultConfig()
    {
        if (config()->has('flashmessages')) {
            $config = config('flashmessages');

            foreach ($config as $key => $value) {
                if ($this->isDefaultConfigAllowedToSet($key) && property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Update the configuration based on the config array passed to the individual message (if any)
     *
     * @param array $messageData The entire `messageData` array passed from the container component
     *
     * @return void
     */
    private function loadMessageConfig(array $messageData)
    {
        if (isset($messageData['config']) && !empty($messageData['config']) && is_array($messageData['config'])) {
            foreach ($messageData['config'] as $key => $value) {
                if ($this->isMessageConfigAllowedToSet($key) && property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Post config processing
     *
     * This re-evaluates how to configure a few settings before continuing and should be called last
     * in the constructor AFTER loading the config passed by the inidivual message itself.
     *
     * @return void
     */
    private function postConfig()
    {
        // if we are forcing the icon
        if ( $this->forceIcon === true ) {
            $this->showIcon = true;
        }

        // if we are supposed to show an icon, but there isn't one, use th fallback icon
        if ( ($this->showIcon === true) && ( ! isset($this->icon) || empty($this->icon) ) ) {
            $this->icon = $this->_fallbackIcon;
        }

        // if we are forcing the title
        if ( $this->forceTitle === true ) {
            $this->showTitle = true;                            // set to true so helpers know
        }

        // if we are supposed to show a title, but there isn't one
        if ( ($this->showTitle === true) && ( ! isset($this->title) || empty($this->title) ) ) {
            $this->title = Str::title($this->type);             // set the title to the type
        }

        // if we are forcing dismissable
        if ($this->forceDismissable === true) {
            $this->dismissable = true;                          // set to true so helpers know
        }
    }

    /**
     * Set the HTML class for the flash message using the `typeToClassMap` array
     *
     * @return void
     */
    private function setClass()
    {
        if ( isset($this->typeToClassMap[$this->type]) ) {
            $this->class = $this->typeToClassMap[$this->type];
        }
    }

    /**
     * Set the icon HTML for the flash message using the `typeToIconMap` array
     *
     * @return void
     */
    private function setIcon()
    {
        if ( isset($this->typeToIconMap[$this->type]) ) {
            $this->icon = $this->typeToIconMap[$this->type];
        }
    }

    /**
     *  =============================================================
     *  Helper functions available to the component's view blade file
     *  =============================================================
     */


     /**
      * Helper function to get the title of the flash message
      *
      * @return string
      */
    public function getTitle()
    {
        return $this->title ?? '';
    }

    /**
     * Helper function to get the text of the message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message ?? '';
    }

    /**
     * Helper function to get the class of the message
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class ?? '';
    }

    /**
     * Helper function to get the icon's HTML
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon ?? '';
    }

    /**
     * Determine if the flash message should be dismissable
     *
     * @return bool
     */
    public function isDismissable()
    {
        return ($this->dismissable === true) ? true : false;
    }

    /**
     * Determine if the flash message has a title
     *
     * @return bool
     */
    public function hasTitle()
    {
        return ( isset($this->title) && ! empty($this->title) ) ? true : false;
    }

    /**
     * Determine if the flash message has a message (it should, but why not lol)
     *
     * @return bool
     */
    public function hasMessage()
    {
        return (isset($this->message) && !empty($this->message)) ? true : false;
    }

    /**
     * Determine if the flash message should show a title
     *
     * Note: We can only show a title if there is one to show. To always show a title
     * you must set `forceTitle` to `true` in `/config/flashmessages.php`. This will
     * convert the `type` (ie: success, error, etc.) to a title (ie: Success, Error, etc.)
     *
     * @return bool
     */
    public function shouldShowTitle()
    {
        return ( ($this->showTitle === true) && $this->hasTitle() ) ? true : false;
    }

    /**
     * Determine if the flash message should show an icon
     *
     * @return bool
     */
    public function shouldShowIcon()
    {
        return ($this->showIcon === true) ? true : false;
    }
}
