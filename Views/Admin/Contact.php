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
            <div class="quark-presence-column form-title">
                Content
            </div>
            <br />
            <div class="quark-presence-column form-value">
                <input id="form-item-content" name="txtfield" type="hidden">
                <div id="toolbar-container">
                <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                </span>
                    <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-strike"></button>
                </span>
                    <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                </span>
                    <span class="ql-formats">
                    <select class="ql-align"></select>
                </span>
                    <span class="ql-formats">
                    <button class="ql-script" value="sub"></button>
                    <button class="ql-script" value="super"></button>
                </span>
                    <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                    <button class="ql-blockquote"></button>
                    <button class="ql-code-block"></button>
                </span>
                    <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                </span>
                    <span class="ql-formats">
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                    <button class="ql-video"></button>
                </span>
                    <span class="ql-formats">
                    <button class="ql-clean"></button>
                </span>
                </div>
                <div id="editor-container">
                    <?php echo $item->txtfield;?>
                </div>
            </div>
        </div>
		<br/>
		<div class="quark-presence-container presence-block button-div" >
			<button class="submit-button quark-button block ok" type="submit">Update</button>
		</div>
	</div>
</form>