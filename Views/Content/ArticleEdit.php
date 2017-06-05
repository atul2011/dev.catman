<?php
/**
 * @var QuarkView|ArticleEditView $this
 * @var QuarkModel|Article $article
 */
use Models\Article;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Content\ArticleEditView;

/**
 * @var QuarkModel|Article $item
 */
$item = new QuarkModel(new Article());
$service = 'create';
$button_name = 'Create';
if (isset($article)) {
	$item = $article;
	$service = 'edit/' . $item->id;
	$button_name = 'Update';
}
?>
<div class="quark-presence-column">
        <div class="quark-presence-container presence-block ">
            <form method="POST" id="form" onsubmit="return checkTitle();" action="/article/<?php echo $service; ?>">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block middle " id="form-div">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input" name="title" id="title"
                               value="<?php echo $item->title; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Release Date</p>
                        <input  type="date" data-date-inline-picker="true" class="quark-input" name="release_date"id="release" value="<?php echo $item->release_date; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Publish Date</p>
                        <input type="date" data-date-inline-picker="true" class="quark-input" name="publish_date" id="publish" value="<?php echo $item->publish_date; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block main" id="form-div">
                    <div class="title"><p>Content</p>
                        <textarea placeholder="Content" cols="50" class="content quark-input" name="txtfield" id="txtfield">
                    <?php echo $item->txtfield; ?>
                </textarea>
                    </div>
                </div>
            </div>
            <div class="quark-presence-column " id="second_div">
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input" name="note"id="note" value="<?php echo $item->note; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Resume</p>
                        <input placeholder="Resume" type="text" class="quark-input" name="resume" id="resume"  value="<?php echo $item->resume; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle" id="form-div">
                    <div class="title"><p>Copyright</p>
                        <input placeholder="Copyright" type="text" class="quark-input" name="copyright" id="copyright" value="<?php echo $item->copyright; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Priority</p>
                        <input placeholder="Priority" type="text" class="quark-input" name="priority" id="priority"  value="<?php echo $item->priority; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle" id="form-div">
                    <div class="title"><p>Type</p>
                        <input placeholder="Type" type="text" class="quark-input" name="type" id="type"value="<?php echo $item->type; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Keywords</p>
                        <input placeholder="keywords" type="text" class="quark-input" name="keywords" id="keywords"value="<?php echo $item->keywords; ?>">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Description</p>
                        <input placeholder="Description" type="text" class="quark-input" name="description" id="description" value="<?php echo $item->description; ?>">
                    </div>
                </div>
            </div>
            <div class="quark-presence-container presence-block" id="form-div">
                <button id="submit-button" class="quark-button block ok" type="submit">
					<?php echo $button_name; ?>
                </button>
            </div>
            </form>
        </div>
</div>

