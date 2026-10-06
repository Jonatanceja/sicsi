<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(public string $name = 'check')
    {
        //
    }

    public static function all(): array
    {
        static $icons;

        return $icons ??= require dirname(__DIR__).'/icons.php';
    }

    public function render(): Closure|string
    {
        $path = e(static::all()[$this->name][1] ?? '');

        return <<<BLADE
        <svg {{ \$attributes->merge(['class' => 'size-6']) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{$path}" /></svg>
        BLADE;
    }
}
