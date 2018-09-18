<?php
use Models\Article;
use Models\Article_has_Photo;
use Models\Article_has_Tag;
use Models\Author;
use Models\Event;
use Models\Photo;
use Models\Tag;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Article\CreateView;

/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Article $item
 */
?>
<h1 class="page-title">Edit Contact Us Page</h1>
<h5 class="page-title">Insert data for update content in page "Contact Us"</h5>
<form method="POST" id="item-form" action="/admin/contact/<?php echo $item->id; ?>">
	<div class="quark-presence-column content-column left">
        <div class="quark-presence-container presence-block middle">
            <div class="quark-presence-column form-title">
                Title
            </div>
            <br />
            <div class="quark-presence-column form-value">
                <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $item->title; ?>">
            </div>
        </div>
        <div class="quark-presence-container presence-block middle">
            <div class="quark-presence-column form-title">Content</div>
            <br />
            <div class="quark-presence-column form-value">
                <textarea name="txtfield" id="editor-container"><?php echo $item->txtfield;?></textarea>
            </div>
        </div>
		<br/>
		<div class="quark-presence-container presence-block button-div" >
			<button class="submit-button quark-button block ok" type="submit">Update</button>
		</div>
	</div>
</form>