<?php

/**
 * Description of StiwlPageThirdSonataMediaBundle
 *
 * @author luchin
 */

namespace Stiwl\PageBundle\Third\SonataMediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class StiwlPageThirdSonataMediaBundle extends Bundle {

    public function getParent() {
        return "ApplicationSonataMediaBundle";
    }

}

?>
