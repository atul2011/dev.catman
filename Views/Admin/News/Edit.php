<?php
use Models\News;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\News\CreateView;

/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|News $news
 */
?>
<h1 class="page-title">Edit Current News</h1>
<h5 class="page-title">Insert data for update selected news</h5>
<form method="POST" id="item-form"  action="/admin/news/edit/<?php echo $news->id; ?>">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Title</p>
						<input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $news->title; ?>"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Type</p>
                        <select class="text_field quark-input" name="type" id="item-type">
							<?php
							echo '<option value="' , strtoupper(News::TYPE_NEW_EVENT) , '" ', $news->type == News::TYPE_NEW_MATERIAL ? 'selected' : '' ,'>New Event</option>';
							echo '<option value="' , strtoupper(News::TYPE_NEW_MATERIAL) , '" ', $news->type == News::TYPE_NEW_MATERIAL ? 'selected' : '' , '>New Published Material</option>';
							echo '<option value="' , strtoupper(News::TYPE_CUSTOM) , '" ', $news->type == News::TYPE_CUSTOM ? 'selected' : '' , '>Custom</option>';
							?>
                        </select>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Link URL</p>
						<input placeholder="Note" type="text" class="quark-input text_field" name="link_url" id="item-link_url" value="<?php echo $news->link_url; ?>"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Link Text</p>
						<input placeholder="Note" type="text" class="quark-input text_field" name="link_text" id="item-link_text" value="<?php echo $news->link_text; ?>"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Publish Date</p>
						<input placeholder="Note" type="date" class="quark-input text_field" name="publish_date" id="item-publish_date" value="<?php echo $news->publish_date->Format('Y-m-d'); ?>"/>
					</div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block main" id="content">
            <input id="form-item-content" name="text" type="hidden">
            <div class="title"><p>Content</p>
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
                    <?php echo $news->text;?>
                </div>
            </div>
		</div>
        <br/>
		<div class="quark-presence-container presence-block button-div">
			<button class="quark-button block ok submit-button" type="submit">Update</button>
		</div>
	</div>
</form>