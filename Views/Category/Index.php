<?php
/**
 * @var QuarkModel|Category $category
 * @var QuarkView|IndexView $this
 */
use Models\Article;
use Models\Category;
use Models\Photo;
use Quark\QuarkModel;
use Quark\QuarkView;
use Quark\ViewResources\ShowdownJS\ShowdownJS;
use ViewModels\Category\IndexView;

$related_categories = '';//sub-categories
$categories = Category::Sort($category->ChildCategories(0));
foreach ($categories as $item) {
	if ($item->keywords === 'super-category')	continue;
	if ($item->specialization === Category::SPECIALIZATION_MOBILE)	continue;

	$related_categories .= '<div class="item-related-categories" id="related-category-' . $item->id . '">'.
								'<a href="/category/'.$item->id.'"> <b>'.
                                    $item->title .
                                '</b></a>'.
						   '</div>';
}

$related_articles = '';//related-articles
$articles = Article::Sort($category->Articles(30));

foreach ($articles as $item) {
	$related_articles .= '<div class="item-related-articles" id="related-article-' . $item->id . '">'.
                             '<a href="/article/'.$item->id.'">'.
                                 $item->title .
                             '</a>'.
                         '</div>';
}
?>
<div class="block-center__left js-equal-height">
	<div class="item-head">
		<h3 class="main-headline item-main-headline">
			<?php echo $category->title;?>
		</h3>
	</div>
    <hr class="cm-delimiter cm-header-content-delimiter">
	<div class="item-content">
		<div class="item-content-container">
            <div class="item-related-content">
                <?php echo $category->intro?>
            </div>
            <hr class="cm-delimiter cm-content-photos-delimiter">
            <div class="item-related-photo-container">
				<?php
				foreach ($category->Photos() as $photo) {
					/**
					 * @var QuarkModel|Photo $photo
					 */
					echo '<img src="' , $photo->file->WebLocation() , '" class="item-related-photo">';
				}
				?>
            </div>
            <hr class="cm-delimiter cm-content-categories-delimiter">
			<div class="item-related-categories-container"><?php echo $related_categories;?></div>
            <hr class="cm-delimiter cm-categories-articles-delimiter">
            <div class="item-related-articles-container"><?php echo $related_articles; ?></div>
		</div>
	</div>
</div>