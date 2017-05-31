<?php
namespace Middleware\Froala;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkCSSViewResourceType;

class FroalaCSSEditor implements IQuarkSpecifiedViewResource
{
    /**
     * @return IQuarkViewResourceType
     */
    public function Type(){
        return new QuarkCSSViewResourceType();
    }

    /**
     * @return string
     */
    public function Location()
    {
        return 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.min.css';
    }

}