<?php
use Models\Article;
use Models\Author;
use Models\Category;
use Models\Event;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
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
				} elseif (isset($sort_values)) {
					$articles = $category->Articles(0);

					foreach ($sort_values as $item) {
						$item_text = '';

						if ($sort_field == 'author_id') {
							/**
							 * @var QuarkModel|Author $item
							 */

							if ($articles->Count(array('author_id.value' => $item->id)) == 0)
								continue;

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
                            if ($articles->Count(array('event_id.value' => $item->id)) == 0)
                                continue;

	                        echo
                                '<div class="item-related-categories">' ,
                                    '<a href="/category/' , $category->id ,'/sort/'  , $sort_field , '/'  , $item->id , '"><b>' ,
                                        $item->name  ,
                                    '</b></a>' ,
                                '</div>';
                        }
                        elseif ($sort_field == 'release_date') {
	                        if ($articles->Count(Article::SearchByYearQuery($item)) == 0)
		                        continue;

	                        echo
                                '<div class="item-related-categories">',
                                    '<a href="/category/', $category->id, '/sort/', $sort_field, '/', $item, '"><b>',
                                        $item,
                                    '</b></a>',
                                '</div>';
                        }

					}
				} elseif (isset($articles)) {
					foreach ($articles as $article)
						echo
						    '<div class="item-related-articles">' ,
                                '<a href="/article/' , $article->id , '">' ,
                                    $article->title != '' ? $article->title : $this->CurrentLocalizationOf('Catman.Localization.Article.EmptyTitle')  ,
                                '</a>' ,
							'</div>';
				}
				?>
			</div>
		</div>
	</div>
</div>