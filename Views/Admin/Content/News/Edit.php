<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|News $news
 */
use Models\News;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Content\News\CreateView;
?>
<h2 class="page-title">Edit Current News</h2>
<h5>Insert data for update selected news</h5>
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
						<input placeholder="Note" type="date" class="quark-input text_field" name="publish-date" id="item-publish_date" value="<?php echo $news->publish_date->Format('Y-m-d'); ?>"/>
					</div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block main" id="content">
			<div class="title"><p>Content</p>
				<textarea placeholder="Content" class="content quark-input" name="text" id="item-text">
                        <?php echo $news->text; ?>
                    </textarea>
			</div>
		</div>
		<div class="quark-presence-container presence-block button-div">
			<br/>
			<button class="quark-button block ok submit-button" type="submit">
				Update
			</button>
		</div>
	</div>
</form>