<?php
namespace ViewResources\Summernote;

use Quark\IQuarkViewResource;
use Quark\IQuarkViewResourceWithBackwardDependencies;
use Quark\ViewResources\TwitterBootstrap\TwitterBootstrap;

class Summernote implements IQuarkViewResourceWithBackwardDependencies {
	/**
	 * @return IQuarkViewResource[]
	 */
	public function BackwardDependencies () {
		return array(
			new TwitterBootstrap(),
			new SummernoteCSS(),
			new SummernoteJS()
		);
	}
}