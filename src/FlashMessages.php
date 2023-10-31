<?php

namespace CyberPunkCodes\FlashMessages;

class FlashMessages
{
    public $bagName = 'flashMessages';

    /**
     * Add a flash message to the session
     *
     * @param string $type The type of flash message (success, error, warning, info, etc.)
     * @param string $message The text of the actual message itself
     * @param array $config The config array to customize the flash message settings (optional)
     *
     * @return void
     */
    public function addFlashMessage(string $type, string $message, array $config = [])
    {
        $oldBag = $this->getFlashMessages();

        $oldBag[] = [
            'type' => $type,
            'message' => $message,
            'config' => $config,
        ];

        request()->session()->flash($this->bagName, $oldBag);
    }

    /**
     * Add a flash message to the session for immediate use.
     *
     * @param string $type The type of flash message (success, error, warning, info, etc.)
     * @param string $message The text of the actual message itself
     * @param array $config The config array to customize the flash message settings (optional)
     *
     * @return void
     */
    public function addFlashMessageNow(string $type, string $message, array $config = [])
    {
        $oldBag = $this->getFlashMessages();

        $oldBag[] = [
            'type' => $type,
            'message' => $message,
            'config' => $config,
        ];

        request()->session()->now($this->bagName, $oldBag);
    }

    /**
     * Whether or not there are flash messages
     *
     * @return bool
     */
    public function hasFlashMessages()
    {
        return request()->session()->has($this->bagName) ? true : false;
    }

    /**
     * Get the flash messages stored in the session
     *
     * @return array Returns an array of the flash messages stored in the session
     */
    public function getFlashMessages()
    {
        return $this->hasFlashMessages() ? request()->session()->get($this->bagName) : [];
    }
}
