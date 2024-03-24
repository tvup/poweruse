<?php


namespace App\Support\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class PowerUsePolicy extends Basic
{
    public function configure()
    {
        parent::configure();

//        $this->addDirective(Directive::SCRIPT, ['https://unpkg.com/vue@3/'])
//            ->addDirective(Directive::STYLE, ['https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/'])
//            ->addDirective(Directive::IMG, 'https://laravel.com');

        $this->addDirective(Directive::IMG, 'https://laravel.com')->reportOnly();
    }

}