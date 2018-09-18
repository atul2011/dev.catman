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
 * @var QuarkModel|Article $article
 * @var QuarkCollection|Author[] $authors
 * @var QuarkCollection|Event[] $events
 */
?>
<h1 class="page-title">Update Article</h1>
<h5 class="page-title">Insert data for update selected article</h5>
<form method="POST" id="item-form" action="/admin/article/edit/<?php echo $article->id; ?>">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block middle">
					<div class="quark-presence-column form-title">
					    Title
					</div>
					<br />
					<div class="quark-presence-column form-value">
						<input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $article->title; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-column form-title">
                        Short Title
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <input placeholder="Short Title" type="text" class="quark-input text_field" name="short_title" id="item-short-title" value="<?php echo $article->short_title; ?>">
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-column form-title">
                        Release Date
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="release_date" id="item-release" value="<?php echo $article->release_date->Format('Y-m-d'); ?>">
                    </div>
				</div>
				<div class="quark-presence-container presence-block  middle">
                    <div class="quark-presence-column form-title">
                        Type
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <select class="quark-input text_field" name="type" id="item-type">
		                    <?php
		                    echo '<option value="' , Article::TYPE_ARTICLE , '" ' , $article->type == Article::TYPE_ARTICLE ? 'selected' : '' , '>Article</option>';
		                    echo '<option value="' , Article::TYPE_ROSARY , '" ' , $article->type == Article::TYPE_ROSARY? 'selected' : '' , '>Rosary</option>';
		                    echo '<option value="' , Article::TYPE_DECREE , '" ' , $article->type == Article::TYPE_DECREE ? 'selected' : '' , '>Decree</option>';
		                    echo '<option value="' , Article::TYPE_EXCERPT , '" ' , $article->type == Article::TYPE_EXCERPT ? 'selected' : '' , '>Excerpt</option>';
		                    echo '<option value="' , Article::TYPE_QUESTION , '" ' , $article->type == Article::TYPE_QUESTION ? 'selected' : '' , '>Question</option>';
		                    echo '<option value="' , Article::TYPE_MESSAGE , '" ' , $article->type == Article::TYPE_MESSAGE ? 'selected' : '' , '>Message</option>';
		                    ?>
                        </select>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-column form-title">
                        Note
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note" value="<?php echo $article->note; ?>">
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle" id="event-field">
                    <div class="quark-presence-column form-title">
                        Event Name
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <select name="event_id" class="quark-input search text_field" id="item-event">
		                    <?php
		                    foreach ($events as $event)
			                    echo '<option value="' , $event->id ,'" ', $article->event_id->value == $event->id ? 'selected' : '' ,'>' , $event->name ,'</option>';
		                    ?>
                        </select>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle" id="author-field">
                    <div class="quark-presence-column form-title">
                        Author Name
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <select name="author_id" class="quark-input search text_field" id="item-author">
		                    <?php
		                    foreach ($authors as $author)
			                    echo '<option value="' , $author->id ,'" ', $article->author_id->value == $author->id ? 'selected' : '' , '>' , $author->name ,'</option>';
		                    ?>
                        </select>
                    </div>
				</div>
			</div><div class="quark-presence-column right" id="second_div">
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-column form-title">
                        Resume
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <input placeholder="Resume" type="text" class="quark-input text_field" name="resume" id="item-resume"  value="<?php echo $article->resume; ?>">
                    </div>
				</div>
                <div class="quark-presence-container presence-block  middle">
                    <div class="quark-presence-column form-title">
                        Copyright
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <input placeholder="Copyright" type="text" class="quark-input text_field" name="copyright"  id="item-copyright" value="<?php echo $article->copyright; ?>">
                    </div>
                </div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-container presence-block  middle">
                        <div class="quark-presence-column form-title">
                            Publish Date
                        </div>
                        <br />
                        <div class="quark-presence-column form-value">
                            <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="publish_date" id="item-publish" value="<?php echo $article->publish_date->Format('Y-m-d'); ?>">
                        </div>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-container presence-block  middle">
                        <div class="quark-presence-column form-title">
                            Priority
                        </div>
                        <br />
                        <div class="quark-presence-column form-value">
                            <input placeholder="Priority" type="text" class="quark-input text_field" name="priority" id="item-priority" value="<?php echo $article->priority; ?>">
                        </div>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-container presence-block  middle">
                        <div class="quark-presence-column form-title">
                            Keywords
                        </div>
                        <br />
                        <div class="quark-presence-column form-value">
                            <input placeholder="keywords" type="text" class="quark-input text_field" name="keywords" id="item-keywords" value="<?php echo $article->keywords; ?>">
                        </div>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-container presence-block  middle">
                        <div class="quark-presence-column form-title">
                            Description
                        </div>
                        <br />
                        <div class="quark-presence-column form-value">
                            <input placeholder="Description" type="text" class="quark-input text_field" name="description" id="item-description" value="<?php echo $article->description; ?>">
                        </div>
                    </div>
				</div>
				<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-container presence-block  middle">
                        <div class="quark-presence-column form-title">
                            Specialization
                        </div>
                        <br />
                        <div class="quark-presence-column form-value">
                            <div class="cm-form-checkbox"><input type="checkbox" name="available_on_site" id="cm-item-available_on_site" value="<?php echo $article->available_on_site;?>">On Site</div>
                            <div class="cm-form-checkbox"><input type="checkbox" name="available_on_api" id="cm-item-available_on_api" value="<?php echo $article->available_on_api;?>">On Api</div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block" id="content-container">
            <div class="quark-presence-container presence-block middle">
                <div class="quark-presence-column form-title">Content</div>
                <br />
                <div class="quark-presence-column form-value">
                    <textarea name="txtfield" id="editor-container"><?php echo $article->txtfield;?></textarea>
                </div>
            </div>
		</div>
        <br />
        <div class="quark-presence-container presence-block  middle">
            <div class="quark-presence-column form-title">
                Insert Tags
            </div>
            <br />
            <div class="quark-presence-column form-value" id="cm-form-tag-container">
                <input type="text" class="quark-input text_field" id="cm-form-tag-input">
                <input type="hidden" value="<?php echo $article->id;?>" id="cm-article-id">
                <button type="button" class="quark-button block ok" id="cm-form-button-add-tag">Add tag</button>
                <br/>
                <br/>
				<?php
				$tags = $article->Tags();

				foreach ($tags as $tag) {
					/**
					 * @var QuarkModel|Tag $tag
					 */
					echo
					'<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" action="/admin/article/tag/unlink/' , Article_has_Tag::GetLink($article, $tag)->id ,'">' ,
					    $tag->name ,'  ',
					'<a class="fa fa-close"></a>',
					'</button>';
				}
				?>
            </div>
        </div>
        <br />
        <div class="quark-presence-container presence-block  middle">
            <div class="quark-presence-column form-title">
                Linked Photos
                <h5>List photos that is already linked:</h5>
            </div>
            <br />
            <div class="quark-presence-column form-value" id="cm-form-linked-photo-container">
				<?php
				$existed = array();
				foreach ($article->Photos() as $photo) {
					/**
					 * @var QuarkModel|Photo $photo
					 */
					echo
					'<button type="button" class="cm-button-photo cm-button-sub-item-action" title="Link photo to this category" action="/admin/article/photo/unlink/' , Article_has_Photo::GetLink($article, $photo)->id ,'">' ,
					'<img src="' , $photo->file->WebLocation() , '" class="cm-form-related-photo" >',
					'</button>';

					$existed[] = $photo->id;
				}
				?>
            </div>
        </div>
        <br/>
        <div class="quark-presence-container presence-block  middle">
            <div class="quark-presence-column form-title">
                Link Photos
                <h5> List of photos ready for link, searched by article's tags:</h5>
            </div>
            <br />
            <div class="quark-presence-column form-value" id="cm-form-photo-links-container">
				<?php
				$tags = $article->Tags();
				$photos = new QuarkCollection(new Photo());

				foreach ($tags as $tag) {
					foreach ($tag->Photos() as $photo) {
						if (in_array($photo->id, $existed))
							continue;

						/**
						 * @var QuarkModel|Photo $photo
						 */
						echo
						'<button type="button" class="cm-button-photo" title="Link photo to this article" onclick="LinkPhoto(\'article\', ', $article->id ,',', $photo->id,', this)">' ,
						'<img src="' , $photo->file->WebLocation() , '" class="cm-form-related-photo">',
						'</button>';

						$existed[] = $photo->id;
					}
				}
				?>
            </div>
        </div>
		<br/>
		<div class="quark-presence-container presence-block button-div" >
			<button class="submit-button quark-button block ok" type="submit">Update</button>
		</div>
	</div>
</form>