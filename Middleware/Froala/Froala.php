<?php
namespace Middleware\Froala;

use Quark\IQuarkViewResource;
use Quark\IQuarkViewResourceWithDependencies;

class Froala implements IQuarkViewResource, IQuarkViewResourceWithDependencies {
    /**
     * @return IQuarkViewResource[]
     */
    public function Dependencies()
    {
        return array(
            new FroalaCSSEditor(),
            new FroalaCSSStyle(),
            new FroalaJS()
        );
    }


}