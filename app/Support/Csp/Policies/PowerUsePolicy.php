<?php


namespace App\Support\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class PowerUsePolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        $this->addDirective(Directive::SCRIPT, ["'nonce-{nonce}'"])
            ->addDirective(Directive::STYLE, ["'nonce-{nonce}'"])
            ->reportOnly();
    }

}