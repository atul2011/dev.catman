<?php
namespace Middleware;
use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkCSSViewResourceType;

class BootstrapCSSStyle implements IQuarkSpecifiedViewResource
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
		return 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
	}

}