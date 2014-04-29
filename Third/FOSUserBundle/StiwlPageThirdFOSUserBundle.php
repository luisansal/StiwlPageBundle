<?php

namespace Stiwl\PageBundle\Third\FOSUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class StiwlPageThirdFOSUserBundle extends Bundle
{
    public function getParent() {
        return "FOSUserBundle";
    }
}
