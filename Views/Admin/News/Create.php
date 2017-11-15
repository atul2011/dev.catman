<?php
/**
 * @var QuarkView|CreateView $this
 */
use Models\News;
use Quark\QuarkView;
use ViewModels\Admin\News\CreateView;
?>
<h1 class="page-title">Add New News</h1>
<h5 class="page-title">Insert data to create an new news</h5>
<form method="POST" id="item-form"  action="/admin/news/create">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Title</p>
						<input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Type</p>
                        <select class="text_field quark-input" name="type" id="item-type">
							<?php
							echo '<option value="' , strtoupper(News::TYPE_NEW_EVENT) , '">New Event</option>';
							echo '<option value="' , strtoupper(News::TYPE_NEW_MATERIAL) , '">New Published Material</option>';
							echo '<option value="' , strtoupper(News::TYPE_CUSTOM) , '">Custom</option>';
							?>
                        </select>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Link URL</p>
						<input placeholder="Note" type="text" class="quark-input text_field" name="link_url" id="item-link_url"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Link Text</p>
						<input placeholder="Note" type="text" class="quark-input text_field" name="link_text" id="item-link_text"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Publish Date</p>
						<input placeholder="Note" type="date" class="quark-input text_field" name="publish_date" id="item-publish_date"/>
					</div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block main" id="content">
			<div class="title"><p>Content</p>
				<textarea placeholder="Content" class="content quark-input" name="text" id="item-text"></textarea>
			</div>
		</div>
		<div class="quark-presence-container presence-block button-div">
			<br/>
			<button class="quark-button block ok submit-button" type="submit">
				Create
			</button>
		</div>
	</div>
</form>