<?php
/**
 * @var QuarkModel|Article $article
 * @var QuarkView|IndexView $this
 */
use Models\Article;
use Models\Photo;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Article\IndexView;

$related_categories = '';
$categories = $article->Categories();
foreach ($categories as $category) {
	$related_categories .= '<div class="item-related-categories" id="related-category-' . $category->id . '">' . $category->title . '</div>';
}
?>
<div class="block-center__left js-equal-height">
    <div class="item-head">
        <h3 class="main-headline item-main-headline" id="content-title">
            <?php echo $article->title;?>
        </h3>
    </div>
    <hr class="cm-delimiter cm-header-content-delimiter">
    <div class="item-content">
        <div class="item-content-container">
            <div class="item-related-content">
	            <?php echo $article->txtfield;?>
            </div>
            <div class="item-related-photo-container">
		        <?php
		        foreach ($article->Photos() as $photo) {
			        /**
			         * @var QuarkModel|Photo $photo
			         */
			        echo '<img src="' , $photo->file->WebLocation() , '" class="item-related-photo">';
		        }
		        ?>
            </div>
        </div>
    </div>
</div>