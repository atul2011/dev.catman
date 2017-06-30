<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Category $category
 */
use Models\Category;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Content\Category\CreateView;

/**
 * @var QuarkModel|Category $item
 */
$item = new QuarkModel(new Category());
$service = 'create';
$button_name = 'Create';
if (isset($category)) {
	$item = $category;
	$service = 'edit/' . $item->id;
	$button_name = 'Update';
}
if(isset($_REQUEST['source']))$service.='?source=EditContent'
?>
<form method="POST" id="form"  action="/category/<?php echo $service; ?>">
    <div class="quark-presence-column content-column left">
        <div class="quark-presence-container content-container  main">
            <div class="quark-presence-column left" id="main_div">
                <div class="quark-presence-container presence-block  middle form-div">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="title" value="<?php echo $item->title; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle category-form-div">
                    <div class="title"><p>Type</p>
                        <input type="text" placeholder="Type" class="quark-input text_field" name="release_date"id="release" value="<?php echo $item->sub; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle category-form-div">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input text_field" name="description"id="description" value="<?php echo $item->note; ?>"/>
                    </div>
                </div>
            </div><div class="quark-presence-column right" id="second_div">
                <div class="quark-presence-container presence-block middle category-form-div">
                    <div class="title"><p>Priority</p>
                        <input placeholder="Priority" type="text" class="quark-input text_field" name="priority"id="priority" value="<?php echo $item->priority; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle category-form-div">
                    <div class="title"><p>Keywords</p>
                        <input type="text" placeholder="Type" class="quark-input text_field" name="keywords"id="keywords" value="<?php echo $item->keywords; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle category-form-div">
                    <div class="title"><p>Description</p>
                        <input type="text" PLACEHOLDER="Description" class="quark-input text_field" name="description" id="description" value="<?php echo $item->description; ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="quark-presence-container presence-block main category-form-div" id="content">
            <div class="title"><p>Content</p>
                <textarea placeholder="Content" class="content quark-input" name="intro" id="intro">
                        <?php echo $item->intro; ?>
                    </textarea>
            </div>
        </div>
        <div class="quark-presence-container presence-block button-div">
            <br/>
            <button class="quark-button block ok submit-button" type="submit">
				<?php echo $button_name; ?>
            </button>
        </div>
    </div>
</form>


