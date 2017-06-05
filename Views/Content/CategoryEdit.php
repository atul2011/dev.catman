<?php
/**
 * @var QuarkView|ArticleEditView $this
 * @var QuarkModel|Category $category
 */
use Models\Category;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Content\ArticleEditView;

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
?>
<div class="quark-presence-column">
    <div class="quark-presence-container presence-block ">
        <form method="POST" id="form" onsubmit="return checkTitle();" action="/category/<?php echo $service; ?>">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block  satellite " id="form-div">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input" name="title" id="title"
                               value="<?php echo $item->title; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block main " id="form-div">
                    <div class="title"><p>Content</p>
                        <textarea placeholder="Content" class="content quark-input" name="intro" id="intro">
                        <?php echo $item->intro; ?>
                    </textarea>
                    </div>
                </div>
            </div>
            <div class="quark-presence-column" id="second_div">
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input" name="description" id="description"  value="<?php echo $item->note; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Type</p>
                        <input type="text" placeholder="Type" data-date-inline-picker="true" class="quark-input" name="release_date" id="release" value="<?php echo $item->sub; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Priority</p>
                        <input placeholder="Priority" type="text" class="quark-input" name="priority" id="priority" value="<?php echo $item->priority; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Keywords</p>
                        <input type="text" placeholder="Type" class="quark-input" name="keywords" id="keywords"  value="<?php echo $item->keywords; ?>"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Description</p>
                        <input type="text" PLACEHOLDER="Description" class="quark-input" name="description"  id="description" value="<?php echo $item->description; ?>"/>
                    </div>
                </div>
            </div>
            <div class="quark-presence-container presence-block ">
                <button id="submit-button" class="quark-button block ok" type="submit">
					<?php echo $button_name; ?>
                </button>
            </div>
        </form>
    </div>
</div>


