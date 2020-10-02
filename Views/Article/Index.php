<?php
use Models\Article;
use Models\Link;
use Models\Photo;
use Models\Category;
use Models\Categories_has_Categories;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Article\IndexView;
/**
 * @var QuarkModel|Article $article
 * @var QuarkCollection|Link[] $links
 * @var QuarkView|IndexView $this
 */

$related_categories = '';
$categories = $article->Categories();
//print_r($categories[0]->id);exit;
$cat_link_f = array();
if(isset($categories) and $categories[0]->id!=''){
//echo "here";exit;
	$flag = "first";
	foreach ($categories as $category) {
		//echo $category->id;exit;
		$lastcatdetail = QuarkModel::FindOneById(new Category(), $category->id);
		        //print_r($lastcatdetail->id);exit;
		        if($lastcatdetail->id!='')
                		$cat_link_f[]= ', <span class="related-item-author italic"><a href="/category/'.$lastcatdetail->id.'">'.$lastcatdetail->short_title.'</a></span>';
		$cats = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => (string)$category->id));
		$related_categories .= '<div class="item-related-categories" id="related-category-' . $category->id . '">' . $category->title . '</div>';
		foreach($cats as $cat){
			$category = $cat->parent_id->Retrieve();
                            //print_r($category);exit;
                            //if($category->sub=='F')
                            {
                                $cat_link_f[]= ', <span class="related-item-author italic"><a href="/category/'.$category->id.'">'.$category->short_title.'</a></span>';
                                $subcats = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => (string)$category->id));
                                //print_r($subcats);exit;
                                foreach($subcats as $subcat){
                                        if($subcat->parent_id->value!='')
                                                $cat_link_f[]= ', <span class="related-item-author italic"><a href="/category/'.$subcat->parent_id->value.'">'.$subcat->parent_id->Retrieve()->short_title.'</a></span>';
				}
                            }
		}
		/*if($cats[0]->parent_id->value!='')
			$cat_link_f[]= ', <span class="related-item-author italic"><a href="/category/'.$cats[0]->parent_id->value.'">'.$cats[0]->parent_id->Retrieve()->short_title.'</a></span>';
		else
			$cat_link_f[]= ''; 
		$cat_link_f[] = ', <span class="related-item-author italic"><a href="/category/'.$category->id.'">'.$category->short_title.'</a></span>';*/
	}
$cat_link_f = array_reverse($cat_link_f);
//print_r($cat_link_f);exit;
}
if($categories[0]->id=='')
{
//echo "here";exit;
$cat_link = array();
	//echo $article->category_id;
	$lastcatdetail = QuarkModel::FindOneById(new Category(), $article->category_id);
	//print_r($lastcatdetail->id);exit;
	if($lastcatdetail->id!='')
		$cat_link[]= ', <span class="related-item-author italic"><a href="/category/'.$lastcatdetail->id.'">'.$lastcatdetail->short_title.'</a></span>';
	//echo $article->category_id;exit;
	$cats = QuarkModel::Find(new Categories_has_Categories(), array('child_id1' => (string)$article->category_id));
	//print_r($cats);exit;
	    //$out = new QuarkCollection(new Category());

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
}
//print_r($cat_link);exit;
if(isset($cat_link_f) and isset($cat_link))
        $cat_link = array_merge($cat_link,$cat_link_f);
//}
if($cat_link=='')
	$cat_link = $cat_link_f;
$cat_link= array_unique($cat_link);

//echo "here";
//print_r($cat_link);exit;
$cat_link = implode($cat_link);
//echo $cat_link;exit;
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
            <div>
                <?php
                foreach ($links as $link) {
                    if ($link->master == true) continue;
	                echo
		                '<div class="item-related-articles" >'.
		                    '<a class="related-item-link" href="'.$link->link.'">' . $link->title . '</a>'.
		                '</div>';
                }
                ?>
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
  <br><br> 
  <div class="related-item-detail">
        <span class="related-item-author italic"><?php echo date('d/m/Y', strtotime($article->release_date))?></span><?php
	if(isset($cat_link))
		echo $cat_link;
	//if(isset($subcat_link))
		//echo $subcat_link;
	?>
   </div>
</div>
