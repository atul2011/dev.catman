<?php
//echo "here";exit;
use Models\Article;
use Models\Category;
use Models\Event;
use Models\Author;
use Models\CategoryGroup;
use Models\CategoryGroupItem;
use Models\Categories_has_Categories;
use Models\Link;
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
 * @var QuarkCollection|Link[] $links
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
	'keywords',
	'description'
));
//print_r($categories);
//echo $category->sub."--".Category::TYPE_NEW;
if ($category->sub == Category::TYPE_NEW)
{
//echo "here";exit;
	$articles = Category::NewCategorySubArticles()->Extract(array(
		'id',
		'title',
		'runtime_priority',
		'grouped',
		'resume',
		'release_date',
		'event_id',
		'type',
		'author_id'
	));
}
else
{
//echo "here";exit;
	//$articles = QuarkModel::Find(new Article(), array(
		//'release_date' => array('$gte' => QuarkDate::GMTNow()->Offset('-183 days')->Format('Y-m-d')),
		//'publish_date' => array('$gte' => QuarkDate::GMTNow()->Format('Y-m-d')),
		//'new_' => '1',
	//));
	//echo $category->id;
	if($category->id=="460" or $category->id=="461" or $category->id=="462"){
		/*$articles = QuarkModel::Find(new Article(), array(
                                                        '$or' => array(
                                                                array('type' => Article::TYPE_ARTICLE),
                                                                array('type' => Article::TYPE_MESSAGE)
                                                        ),
                                                        'available_on_site' => true
                                                ), array(
                                                        QuarkModel::OPTION_FIELDS => array(
                                                                'id',
                                                                'title',
                                                                'release_date',
                                                                'publish_date',
                                                                'copyright',
                                                                'priority',
                                                                'type',
                                                                'event_id',
                                                                'author_id',
                                                                'short_title',
                                                                'resume'
                                                        )
                                                ))->Select( array(
                                                        QuarkModel::OPTION_SORT => array(
                                                                'release_date' => QuarkModel::SORT_ASC,
                                                                'title' => QuarkModel::SORT_ASC
                                                        )
                                                ));
		print_r($articles);*/
		$articles = Category::NewCategoryNewArticles($category->id)->Extract(
			array(
                		'id',
	                	'title',
	        	        'runtime_priority',
        	        	'grouped',
	        	        'resume',
				'release_date',
				'event_id',
				'type',
				'author_id'
	        	)
		);

	}else{
		$articles = Article::Minimize($category->Articles(array(
			QuarkModel::OPTION_LIMIT => 30,
			QuarkModel::OPTION_SORT => array('runtime_priority' => QuarkModel::SORT_ASC)
		)))->Extract();
		//print_r($articles);
	}

}
//------------------------------------------
//Create List

//Groups
/**
 * @var QuarkCollection|CategoryGroup[] $groups
 * @var QuarkCollection|CategoryGroupItem[] $group_items
 */
$groups_childes = array();
$groups = $category->Groups();
//echo "here";exit;
//echo "groups ";
//print_r($groups);
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
			}

			$groupItemResume = strlen(trim($item->description)) > 0
				? ('<div class="related-item-detail">' . $item->description  . '</div>')
				: (strlen(trim($item->note)) > 0
					? ('<div class="related-item-detail">' . $item->note  . '</div>')
					: ''
				);
			$groupItem =
				'<div class="item-related-categories" id="related-category-' . $item->id . '">'.
				'<a class="related-item-link" href="/category/'.$item->id.'">'.
				'<b><span class="related-item-label">' . $this->CurrentLocalizationOf('Catman.Category.Label.The') . ': ' . '</span></b>' .
				$item->title .
				'</a>'.
				'<br />' .
				$groupItemResume .
				'</div>';

			$groups_childes[$group->id] .= $groupItem;

		}

		if ($group_item->type == CategoryGroupItem::TYPE_ARTICLE) {
			/**
			 * @var QuarkModel|Article $item
			 */
			$item = QuarkModel::FindOneById(new Article(), $group_item->target);

			if ($item == null) {
				Quark::Log('cannot find article of group:');
			}
			$groupItemResume = strlen(trim($item->resume)) > 0 ? ('<div class="related-item-detail">' . $item->resume  . '</div>') : '';
			$groupItem =
				'<div class="item-related-categories">'.
				'<a class="related-item-link" href="/article/'.$item->id.'">' . $item->title . '</a>'.
				'<br />' .
				$groupItemResume.
				'</div>';

			$groups_childes[$group->id] .= $groupItem;

		}
	}
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
			//if ($category->master) 
			{
				echo '<div class="item-related-categories-container">';
				//print_r($categories);
				foreach ($categories as $item) {
					/**
					 * @var QuarkModel|Category $item
					 */
					if ($item->keywords === 'super-category' || $item->available_on_site !== true || strlen(trim($item->title)) == 0 || $item->grouped == 'true')
						continue;

					$itemResume = strlen(trim($item->description)) > 0
						? ('<div class="related-item-detail">' . $item->description  . '</div>')
						: (strlen(trim($item->note)) > 0
							? ('<div class="related-item-detail">' . $item->note  . '</div>')
							: ''
						);
					echo
						'<div class="item-related-categories" id="related-category-' . $item->id . '">'.
						'<a href="/category/'.$item->id.'">'.
						//'<b><span class="related-item-label">' . $this->CurrentLocalizationOf('Catman.Category.Label.The') . ': ' . '</span></b>' .
						//'<b><span class="related-item-label">' . $this->CurrentLocalizationOf('Catman.Category.Label.The') . ': ' . '</span></b>' .
						'<b>'.$item->title.'</b>' .
						'</a>'.
						'<br />' .
						$itemResume .
						'</div>';
				}

				echo '</div>';
			}
			?>
            <div class="item-related-articles-container">
				<?php
				//echo "articles - ";
				//print_r($articles);exit;
				//print_r($category);exit;
				if(isset($category)){
					//echo $category->id;exit;
					$cats = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => (string)$category->id));
					//print_r($cats);exit;
					foreach ($cats as $cat) {
             			           //echo "here";exit;
			                    /**
			                     * @var QuarkModel|Category $category
			                     */
					    //print_r($cat->parent_id->value);exit;
			                    if($cat->parent_id->value!=''){
                        			$category = $cat->parent_id->Retrieve();
		                                //print_r($category);exit;
                   				      //if($category->sub=='F')
						      {
			                                $cat_link[]= ', <span class="related-item-author italic"><a href="/category/'.$category->id.'">'.$category->short_title.'</a></span>';
                        			        $subcats = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => (string)$category->id));
							//print_r($subcats);exit;
							foreach($subcats as $subcat){
								if($subcat->parent_id->value!='')
				                                	$cat_link[]= ', <span class="related-item-author italic"><a href="/category/'.$subcat->parent_id->value.'">'.$subcat->parent_id->Retrieve()->short_title.'</a></span>';
							}
						      }
                    			    }
				                    //$out[] = $category;
            	    		        }
					$cat_link= array_unique($cat_link);
					$cat_link = array_reverse($cat_link);
					//print_r($cat_link);
					$cat_link = implode($cat_link);
					/*if($cats[0]->parent_id->value!='')
						$cat_link = ', <span class="related-item-author italic"><a href="/category/'.$cats[0]->parent_id->value.'">'.$cats[0]->parent_id->Retrieve()->short_title.'</a></span>';
					else
						$cat_link = '';
					$subcat_link = ', <span class="related-item-author italic"><a href="/category/'.$category->id.'">'.$category->short_title.'</a></span>';*/
		    		}
				//print_r($sort_values);
				foreach ($articles as $item) {
					//print_r($category);
					$event = QuarkModel::FindOneById(new Event(), $item->event_id);
						//print_r($event);
						if ($event != null){
							if(strpos($event->name,'-')>0){
								$eventtitle = ", ".substr($event->name,0,strpos($event->name,'-'));
							}else{
								$eventtitle = '';
							}
							$msg_with_articles = $event->msg_with_articles;
							$msg_without_articles = $event->msg_without_articles;
						}
					$author = QuarkModel::FindOneById(new Author(), $item->author_id);
						if($author != null){
							$authorname = $author->name;
						}
					/**
					 * @var QuarkModel|Article $item
					 */
					//print_r($event);
					//echo "<br>";
					if (strlen(trim($item->title)) == 0 || $item->grouped == 'true')
						continue;

					if ($item->master) continue;

					$itemResume = strlen(trim($item->resume)) > 0 ? ('<div class="related-item-detail">' . $item->resume  . '</div>') : '';
					//echo $item->type;
					if($item->type=="M" or $item->type=="A"){
						if($authorname == "No name"){
							$authorinfo = "";
						}else{
                                			$authorinfo = '<span class="related-item-author italic">'. $authorname . '</span>,';
						}
                        		}
					echo
						'<div class="item-related-articles" id="related-article-' . $item->id . '">'.
						'<a class="related-item-link" href="/article/'.$item->id.'">' . $item->title . '</a>'.
						'<br />'.$itemResume;
					echo    '<div class="related-item-detail">',$authorinfo , ' <span class="related-item-author italic">' , date('d/m/Y',strtotime($item->release_date)) , '</span>',
						$cat_link,
						//$subcat_link,
                                                '<span class="related-item-author italic">', $eventtitle , '</span>',
                                                '</div>',
						'</div>';
					//echo $item->release_date;exit;

					;
				}
				?>
            </div>
			<?php
			foreach ($groups_childes as $group_id => $childes) {
				if (strlen($childes) == 0) continue;
				echo
					'<div class="cm-group-container">' .
					'<h3 class="cm-group-title">' . ($groups->SelectOne(array('id' => (string)$group_id))->title) .'</h3>'.
					$childes .
					'</div>';
			}

			foreach ($links as $link) {
				if ($link->master == true) continue;
				echo
					'<div class="item-related-articles" >'.
					'<a class="related-item-link" href="'.$link->link.'">' . $link->title . '</a>'.
					'</div>';
			}
			?>
        </div>
    </div>
</div>
