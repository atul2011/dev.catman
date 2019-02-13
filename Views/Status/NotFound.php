<?php
/**
 * @var QuarkView|NotFoundView $this
 * @var string $model
 */
use Quark\QuarkView;
use ViewModels\Content\Status\NotFoundView;

?>
<div class="block-center__left js-equal-height">
    <div class="item-head">
        <h3 class="main-headline item-main-headline">
			<?php echo $this->CurrentLocalizationOf('Catman.Status.404')?>
        </h3>
    </div>
    <div class="item-content">
        <div class="item-content-container">
			<?php
            echo $this->CurrentLocalizationOf('Catman.' . $model . '.Label.The').
				 ' ' .
				 $this->CurrentLocalizationOf('Catman.' . $model . '.Status.NotFound');
			?>
        </div>
    </div>
</div>
