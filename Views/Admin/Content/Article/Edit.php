<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Article $article
 * @var QuarkCollection|Tag[] $tags
 */

use Models\Article;
use Models\Tag;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Content\Article\CreateView;

?>
<h2 class="page-title">Update Article</h2>
<h5>Insert data for update selected article</h5>
<form method="POST" id="item-form"action="/admin/article/edit/<?php echo $article->id; ?>">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Title</p>
						<input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $article->title; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Release Date</p>
						<input type="date" data-date-inline-picker="true" class="quark-input text_field" name="release_date" id="item-release" value="<?php echo $article->release_date->Format('Y-m-d'); ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Type</p>
						<input placeholder="Type" type="text" class="quark-input text_field" name="type" id="item-type" value="<?php echo $article->type; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Note</p>
						<input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note" value="<?php echo $article->note; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle" id="event-field">
					<div class="title"><p>Event Name</p>
						<input placeholder="Event Name" list="eventlist" type="text" class="quark-input search text_field" autocomplete="on" name="event" id="item-event" value="<?php echo $article->event_id->name; ?>"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle" id="author-field">
					<div class="title"><p>Author Name</p>
						<input placeholder="Author name" list="authorlist" type="text"  class="quark-input search text_field" autocomplete="on" name="author" id="item-author" value="<?php echo $article->author_id->name; ?>"/>
					</div>
				</div>
			</div><div class="quark-presence-column right" id="second_div">
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Resume</p>
						<input placeholder="Resume" type="text" class="quark-input text_field" name="resume" id="item-resume"  value="<?php echo $article->resume; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Publish Date</p>
						<input type="date" data-date-inline-picker="true" class="quark-input text_field" name="publish_date" id="item-publish" value="<?php echo $article->publish_date->Format('Y-m-d'); ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Copyright</p>
						<input placeholder="Copyright" type="text" class="quark-input text_field" name="copyright"  id="item-copyright" value="<?php echo $article->copyright; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Priority</p>
						<input placeholder="Priority" type="text" class="quark-input text_field" name="priority" id="item-priority" value="<?php echo $article->priority; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Keywords</p>
						<input placeholder="keywords" type="text" class="quark-input text_field" name="keywords" id="item-keywords" value="<?php echo $article->keywords; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Description</p>
						<input placeholder="Description" type="text" class="quark-input text_field" name="description" id="item-description" value="<?php echo $article->description; ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block" id="content-container">
			<div class="title"><p>Tags</p>
				<input type="text" placeholder="Tags, divided by [,]" class="large_text_field quark-input" name="tag_list" id="item-tags" value="<?php foreach ($tags as $tag) echo $tag->name . ',';?>">
			</div>
			<div class="title"><p>Content</p>
				<textarea placeholder="Content" class="content quark-input" name="txtfield" id="txtfield">
                        <?php echo $article->txtfield; ?>
            </textarea>
			</div>
		</div>
		<br/>
		<div class="quark-presence-container presence-block button-div" >
			<button class="submit-button quark-button block ok" type="submit">
				Update
			</button>
		</div>
	</div>
</form>