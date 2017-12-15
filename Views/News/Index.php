<?php
/**
 * @var QuarkModel|News $news
 * @var QuarkView|IndexView $this
 */
use Models\News;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\News\IndexView;

$news_title = '';
$news_content = '';
$news->title != '' ? $news_title = $news->title : $news_title = $news->link_text;
$news->text != '' ? $news_content = $news->text : $news_content = $this->CurrentLocalizationOf('Catman.News.Empty.Text');
?>
<div class="block-center__left js-equal-height">
	<div class="item-head">
		<h3 class="main-headline item-main-headline" id="content-title">
			<?php echo $news_title;?>
		</h3>
	</div>
	<div class="item-content">
		<div class="item-content-container">
			<?php echo $news_content?>
		</div>
	</div>
</div>