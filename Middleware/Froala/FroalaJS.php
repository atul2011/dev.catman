<?php
namespace Middleware\Froala;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResource;
use Quark\IQuarkViewResourceType;
use Quark\IQuarkViewResourceWithDependencies;
use Quark\QuarkJSViewResourceType;
use Quark\ViewResources\jQuery\jQueryCore;

class FroalaJS implements IQuarkSpecifiedViewResource, IQuarkViewResourceWithDependencies
{
    /**
     * @return IQuarkViewResourceType
     */
    public function Type()
    {
        return new QuarkJSViewResourceType();
    }

    /**
     * @return string
     */
    public function Location()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/js/froala_editor.min.js';
    }

    /**
     * @return IQuarkViewResource[]
     */
    public function Dependencies()
    {
        return array(
            new jQueryCore()
        );
    }

}