<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $title;
    public $message;
    public $link;
    public $linkText;
    public $dismissible;
    public $style;

    public function __construct(
        string $type = 'info',
        ?string $title = null,
        ?string $message = null,
        ?string $link = null,
        string $linkText = 'Learn more',
        bool $dismissible = true
    ) {
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
        $this->linkText = $linkText;
        $this->dismissible = $dismissible;
        $this->style = $this->getStyle();
    }

    public function getStyle(): array
    {
        $types = [
            'success' => [
                'border' => 'border-l-4 border-green-400',
                'bg' => 'bg-green-600/20',
                'text' => 'text-green-800',
                'icon' => 'check-circle',
                'defaultTitle' => 'Success!',
            ],
            'error' => [
                'border' => 'border-l-4 border-red-400',
                'bg' => 'bg-red-600/20',
                'text' => 'text-red-800',
                'icon' => 'x-circle',
                'defaultTitle' => 'Error!',
            ],
            'warning' => [
                'border' => 'border-l-4 border-yellow-400',
                'bg' => 'bg-yellow-400/20',
                'text' => 'text-yellow-800',
                'icon' => 'alert-triangle',
                'defaultTitle' => 'Warning!',
            ],
            'info' => [
                'border' => 'border-l-4 border-blue-400',
                'bg' => 'bg-blue-600/20',
                'text' => 'text-blue-800',
                'icon' => 'info',
                'defaultTitle' => 'Info',
            ],
        ];

        return $types[$this->type] ?? $types['info'];
    }


    public function render()
    {
        return view('components.alert');
    }
}
