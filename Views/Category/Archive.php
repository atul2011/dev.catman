<?php
//echo "here";exit;
use Models\Article;
use Models\Author;
use Models\Category;
use Models\Event;
use Models\Settings;
use Models\Categories_has_Categories;
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
if(isset($settings)){
	foreach($settings as $setting){
		$eventmsg[$setting->setting_name] = $setting->setting_value;
		//echo "<br>";
	}
}
//print_r($eventmsg);
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
		//echo "sort fields ".$sort_fields;
            if (isset($sort_fields) && !isset($sort_values) && !isset($articles)) {
	            foreach ($sort_fields as $key => $value)
		            echo
		            '<div class="item-related-categories">' ,
                        '<a href="/category/' , $category->id , '/sort/' , $key  , '"><b>' ,
                            $this->CurrentLocalizationOf($value) , '</b>',
                        '</a>' ,
		            '</div>';
            }

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
                    else if ($sort_field == Category::ARCHIVE_SORT_EVENT){
                        //echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.Event.NoArticles');
			//echo $eventmsg["empty_events"];
			//echo '<hr class="cm-delimiter cm-content-categories-delimiter">';
			echo $msg_without_articles;
		    }
                    else if ($sort_field == Category::ARCHIVE_SORT_DATE)
                        echo $this->CurrentLocalizationOf('Catman.Localization.Category.Arhive.ReleaseDate.NoArticles');
                }
                else {
		    if(isset($category)){
			$cats = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => (string)$category->id));
			//print_r($cats[0]->parent_id->value);
			$cat_link = ', <span class="related-item-author italic"><a href="/category/'.$cats[0]->parent_id->value.'">'.$cats[0]->parent_id->Retrieve()->short_title.'</a></span>';
			$subcat_link = ', <span class="related-item-author italic"><a href="/category/'.$category->id.'">'.$category->short_title.'</a></span>';
		    }
                    $already_in = array();
                    foreach ($articles as $article) {
			//echo $article->type;
			//if($article->type=="M" or $article->type=="A"){
				$authorinfo = '<span class="related-item-author italic">'. $article->author_id->Retrieve()->name . '</span>,';
			//}
                        echo
                            '<div class="item-related-articles">' ,
                                '<a class="related-item-title" href="/article/' , $article->id , '"><b>' , ($article->title != '' ? $article->title : $this->CurrentLocalizationOf('Catman.Localization.Article.EmptyTitle'))  , '</b></a>' ,
                                '<div class="related-item-detail">',$authorinfo , ' <span class="related-item-author italic">' , $article->release_date->Format('d / m / Y') , '</span>',
				$cat_link,
				$subcat_link,
				'</div>' ,
                            '</div>';
				//', <span class="related-item-author">', substr($sort_field_title,0,strpos($sort_field_title,'-')) , '</span>',
			//print_r($title);
                    }
			echo '<hr class="cm-delimiter cm-content-categories-delimiter">';
			echo $msg_with_articles;
                }
            }
            ?>
        </div>
	</div>
</div>
