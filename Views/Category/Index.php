<?php
use Models\Article;
use Models\Category;
use Models\CategoryGroup;
use Models\CategoryGroupItem;
use Models\Photo;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Category\IndexView;

/**
 * @var QuarkModel|Category $category
 * @var QuarkCollection|Category[] $categories
 * @var QuarkCollection|Article[] $articles
 * @var QuarkView|IndexView $this
 */
//Define Variable
$related_categories = '';//sub-categories
$related_articles = '';//related-articles

$categories = $category->ChildCategories(0)->Extract(array(
	'id',
	'title',
	'runtime_priority',
	'grouped',
    'note',
    'available_on_site',
    'keywords'
));

if ($category->sub == Category::TYPE_NEW)
	$articles = Category::NewCategorySubArticles()->Extract(array(
		'id',
		'title',
		'runtime_priority',
		'grouped',
		'resume'
	));
else
	$articles = Article::Sort($category->Articles(30))->Extract();

//------------------------------------------
//Create List

//Groups
/**
 * @var QuarkCollection|CategoryGroup[] $groups
 * @var QuarkCollection|CategoryGroupItem[] $group_items
 */
$groups_childes = array();
$groups = $category->Groups();

foreach ($groups as $group) {
    $group_items = $group->Items();
    $groups_childes[$group->id] = '';

    foreach ($group_items as $group_item) {
        if ($group_item->type == CategoryGroupItem::TYPE_CATEGORY) {
            /**
             * @var QuarkModel|Category $item
             */
            $item= QuarkModel::FindOneById(new Category(), $group_item->target);

            if ($item == null) {
                Quark::Log('cannot find category of group:');
                Quark::Trace($group_item);
            }

	        $groups_childes[$group->id] .=
		        ('<div class="item-related-categories" id="related-category-' . $item->id . '">'.
                    '<a class="related-item-link" href="/category/'.$item->id.'">'.
                    '<b><span class="related-item-label">' . $this->CurrentLocalizationOf('Catman.Category.Label.The') . ': ' . '</span></b>' .
                        $item->title .
                        '</a>'.
                    '<br />' .
                    '<div class="related-item-detail">' . $item->note  . '</div>' .
		        '</div>');

        }

	    if ($group_item->type == CategoryGroupItem::TYPE_ARTICLE) {
		    /**
		     * @var QuarkModel|Article $item
		     */
		    $item = QuarkModel::FindOneById(new Article(), $group_item->target);

		    if ($item == null) {
			    Quark::Log('cannot find article of group:');
			    Quark::Trace($group_item);
		    }

		    $groups_childes[$group->id] .=
			    ('<div class="item-related-categories" id="related-category-' . $item->id . '">'.
                    '<a class="related-item-link" href="/article/'.$item->id.'">' . $item->title . '</a>'.
                    '<br />' .
                    '<div class="related-item-detail">' . $item->note  . '</div>' .
			    '</div>');

	    }
    }
}

//Related Categories
foreach ($categories as $item) {
	if ($item->keywords === 'super-category' || $item->available_on_site !== true || strlen(trim($item->title)) == 0 || $item->grouped == 'true')
	    continue;

	$related_categories .=
	    '<div class="item-related-categories" id="related-category-' . $item->id . '">'.
            '<a class="related-item-link" href="/category/'.$item->id.'">'.
                '<b><span class="related-item-label">' . $this->CurrentLocalizationOf('Catman.Category.Label.The') . ': ' . '</span></b>' .
                $item->title .
            '</a>'.
            '<br />' .
            '<div class="related-item-detail">' . $item->note  . '</div>' .
       '</div>';
}

//Related Articles
foreach ($articles as $item) {
    if (strlen(trim($item->title)) == 0 || $item->grouped == 'true')
        continue;

	$related_articles .=
	    '<div class="item-related-articles" id="related-article-' . $item->id . '">'.
            '<a class="related-item-link" href="/article/'.$item->id.'">' . $item->title . '</a>'.
            '<br />'.
            '<div class="related-item-detail">' .$item->resume  . '</div>' .
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
            <?php

            if (strlen($related_categories) > 0 && !$category->master) {
                echo
			        '<div class="item-related-categories-container">'  , $related_categories . '</div>';
            }
            ?>
            <div class="item-related-articles-container"><?php echo $related_articles; ?></div>
            <?php
            foreach ($groups_childes as $group_id => $childes) {
                if (strlen($childes) == 0) continue;
	            echo
		            '<div class="cm-group-container">' .
		            '<h3 class="cm-group-title">' . ($groups->SelectOne(array('id' => (string)$group_id))->title) .'</h3>'.
		            $childes .
		            '</div>';

            }
            ?>
		</div>
	</div>
</div>