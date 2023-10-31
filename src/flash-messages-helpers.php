<?php

if ( ! function_exists('hasFlashMessages') ) {
    function hasFlashMessages() {
        return \CyberPunkCodes\FlashMessages\Facades\FlashMessages::hasFlashMessages();
    }
}
