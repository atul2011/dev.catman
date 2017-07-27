<?php
/**
 * @var QuarkView|NotFoundView $this
 * @var string $model
 */
use Quark\QuarkView;
use ViewModels\Admin\Status\NotFoundView;

?>
<h1 class="page-title">
	<?php echo $this->CurrentLocalizationOf('Catman.Status.404') ?>
</h1>
<h4 class="page-title">
    <?php
    echo $this->CurrentLocalizationOf('Catman.' . $model . '.Label.The') .
        ' ' .
        $this->CurrentLocalizationOf('Catman.' . $model . '.Status.NotFound');
    ?>
</h4>
