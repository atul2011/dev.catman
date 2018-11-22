<?php
/**
 * @var QuarkView|IndexView $this
 * @var QuarkModel|Article $article
 * @var QuarkCollection|Banner[] $banners
 */
use Models\Article;
use Models\Banner;
use Models\Photo;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Content\IndexView;

/**
 * @var QuarkCollection|Banner[] $random_banner
 * @var QuarkModel|Banner $banner
 */
$random_banner = QuarkModel::FindRandom(new Banner());
$banner = $random_banner[0];
?>
<div class="block-center__left js-equal-height">
	<div class="item-head">
        <?php
        if($banner != null)
            echo
                '<a href="' , $banner->link , '">' ,
                    '<img class="main-page-banner" src="' , $banner->file->WebLocation() , '">' ,
                '</a>';
        ?>
	</div>
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
