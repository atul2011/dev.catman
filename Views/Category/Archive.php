<?php
use Models\Article;
use Models\Author;
use Models\Category;
use Models\Event;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Category\IndexView;

/**
 * @var QuarkModel|Category $category
 * @var array $sort_fields
 * @var array $sort_values
 * @var string $sort_field
 * @var QuarkView|IndexView $this
 * @var QuarkCollection|Article[] $articles
 */
$related_items = '';
?>
<div class="block-center__left js-equal-height">
	<div class="item-head">
		<h3 class="main-headline item-main-headline"><?php echo $category->title;?></h3>
	</div>
	<div class="item-content">
		<div class="item-content-container">
			<?php echo $category->intro;?>
			<div class="item-related-categories-container">
				<?php

				if (isset($sort_fields)) {
					foreach ($sort_fields as $key => $value)
						echo
						    '<div class="item-related-categories">' ,
                                '<a href="/category/' , $category->id , '/sort/' , $key  , '"><b>' ,
                                    $this->CurrentLocalizationOf($value) ,
                                '</b></a>' ,
							'</div>';
				}
				if (isset($sort_values)) {
					foreach ($sort_values as $item) {
						$item_text = '';

						if ($sort_field == 'author_id') {
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
                        elseif ($sort_field == 'event_id') {
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
                        elseif ($sort_field == 'release_date') {
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
						if ($sort_field == 'author_id')
							echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.Author.NoArticles');
						else if ($sort_field == 'event_id')
							echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.Event.NoArticles');
						else if ($sort_field == 'release_date')
							echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.ReleaseDate.NoArticles');
					} else
                        foreach ($articles as $article) {
                            echo
                                '<div class="item-related-articles">' ,
                                    '<a href="/article/' , $article->id , '">' ,
                                        $article->title != '' ? $article->title : $this->CurrentLocalizationOf('Catman.Localization.Article.EmptyTitle')  ,
                                    '</a>' ,
                                '</div>';
                        }
				}
				?>
			</div>
		</div>
	</div>
</div>