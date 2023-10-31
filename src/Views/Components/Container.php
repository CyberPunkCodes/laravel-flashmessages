<?php

namespace CyberPunkCodes\FlashMessages\Views\Components;

use Illuminate\View\Component;
use CyberPunkCodes\FlashMessages\Facades\FlashMessages;

class Container extends Component
{
    public $messages = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->messages = FlashMessages::getFlashMessages();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('flashmessages::components.container');
    }
}
