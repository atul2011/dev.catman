<?php
use Models\Article;
use Models\Author;
use Models\Category;
use Models\Event;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Category\IndexView;

/**
 * @var QuarkModel|Category $category
 * @var array $sort_fields
 * @var array $sort_values
 * @var string $sort_field
 * @var string $sort_field_title
 * @var QuarkView|IndexView $this
 * @var QuarkCollection|Article[] $articles
 */
$related_items = '';
$title = $category->title;

if (isset($sort_field_title)) {
    if ($sort_field == Category::ARCHIVE_SORT_DATE)
        $title .= ', ' . $sort_field_title;
    else
        $title = $sort_field_title;
}
?>
<div class="block-center__left js-equal-height">
	<div class="item-head">
		<h3 class="main-headline item-main-headline"><?php echo $title;?></h3>
	</div>
    <hr class="cm-delimiter cm-header-content-delimiter">
	<div class="item-content">
		<div class="item-content-container">
			<?php echo $category->intro;?>
        </div>
        <hr class="cm-delimiter cm-content-categories-delimiter">
        <div class="item-related-categories-container">
            <?php

            if (isset($sort_values)) {
	            if ($sort_field == Category::ARCHIVE_SORT_AUTHOR)
		            echo '<h4>' . $this->CurrentLocalizationOf('Catman.Localization.Article.ArhiveSortType.Author') .'</h4>';
                elseif ($sort_field == Category::ARCHIVE_SORT_EVENT && $category->sub == Category::TYPE_ARCHIVE)
	                echo '<h4>' . $this->CurrentLocalizationOf('Catman.Localization.Article.ArhiveSortType.Event') .'</h4>';
                elseif ($sort_field == Category::ARCHIVE_SORT_DATE)
	                echo '<h4>' . $this->CurrentLocalizationOf('Catman.Localization.Article.ArhiveSortType.RealeaseDate') .'</h4>';

                foreach ($sort_values as $item) {
                    $item_text = '';

                    if ($sort_field == Category::ARCHIVE_SORT_AUTHOR) {
                        /**
                         * @var QuarkModel|Author $item
                         */
                        echo
                            '<div class="item-related-categories">' ,
                                '<a href="/category/' , $category->id ,'/sort/'  , $sort_field , '/'  , $item->id , '"><b>' ,
                                    $item->name  ,
                                '</b></a>' ,
                            '</div>';
                    }
                    elseif ($sort_field == Category::ARCHIVE_SORT_EVENT) {
                        /**
                         * @var QuarkModel|Event $item
                         */
                        echo
                            '<div class="item-related-categories">' ,
                                '<a href="/category/' , $category->id ,'/sort/'  , $sort_field , '/'  , $item->id , '"><b>' ,
                                    $item->name  ,
                                '</b></a>' ,
                            '</div>';
                    }
                    elseif ($sort_field == Category::ARCHIVE_SORT_DATE) {
                        echo
                            '<div class="item-related-categories">',
                                '<a href="/category/', $category->id, '/sort/', $sort_field, '/', $item, '"><b>',
                                    $item,
                                '</b></a>',
                            '</div>';
                    }

                }
            }
            if (isset($articles)) {
                if (sizeof($articles) == 0) {
                    if ($sort_field == Category::ARCHIVE_SORT_AUTHOR)
                        echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.Author.NoArticles');
                    else if ($sort_field == Category::ARCHIVE_SORT_EVENT)
                        echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.Event.NoArticles');
                    else if ($sort_field == Category::ARCHIVE_SORT_DATE)
                        echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.ReleaseDate.NoArticles');
                }
                else {
                    $already_in = array();
                    foreach ($articles as $article) {
                        echo
                            '<div class="item-related-articles">' ,
                                '<a class="related-item-title" href="/article/' , $article->id , '"><b>' , ($article->title != '' ? $article->title : $this->CurrentLocalizationOf('Catman.Localization.Article.EmptyTitle'))  , '</b></a>' ,
                                '<div class="related-item-detail"><span class="related-item-author italic">' , $article->author_id->Retrieve()->name , '</span>, <span class="related-item-date">' , $article->release_date->Format('d / m / Y') , '</span></div>' ,
                            '</div>';
                    }
                }
            }
            ?>
        </div>
	</div>
</div>
