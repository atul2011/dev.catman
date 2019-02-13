<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkCollection|Author[] $authors
 * @var QuarkCollection|Event[] $events
 */
use Models\Article;
use Models\Author;
use Models\Event;
use Quark\QuarkCollection;
use Quark\QuarkView;
use ViewModels\Admin\Article\CreateView;
?>
<h1 class="page-title">Add New Article</h1>
<h5 class="page-title">Insert data for create new article</h5>
<form method="POST" id="item-form" action="/admin/article/create">
    <div class="quark-presence-column content-column left">
        <div class="quark-presence-container content-container  main">
            <div class="quark-presence-column left" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Short Title</p>
                        <input placeholder="Short Title" type="text" class="quark-input text_field" name="short_title" id="item-short-title">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Release Date</p>
                        <input type="datetime-local" data-date-inline-picker="true" class="quark-input text_field" name="releasedate" id="item-release">
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle">
                    <div class="title"><p>Type</p>
                        <select class="quark-input text_field" name="type" id="item-type">
		                    <?php
			                    echo '<option value="' , Article::TYPE_ARTICLE , '">Article</option>';
			                    echo '<option value="' , Article::TYPE_ROSARY , '">Rosary</option>';
			                    echo '<option value="' , Article::TYPE_DECREE , '">Decree</option>';
			                    echo '<option value="' , Article::TYPE_QUESTION , '">Question</option>';
			                    echo '<option value="' , Article::TYPE_EXCERPT , '">Excerpt</option>';
			                    echo '<option value="' , Article::TYPE_MESSAGE , '">Message</option>';
		                    ?>
                        </select>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="event-field">
                    <div class="title"><p>Event Name</p>
                        <select name="event_id" class="quark-input search text_field" id="item-event">
		                    <?php
		                    foreach ($events as $event)
			                    echo '<option value="' , $event->id ,'">' , $event->name ,'</option>';
		                    ?>
                        </select>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="author-field">
                    <div class="title"><p>Author Name</p>
                        <select name="author_id" class="quark-input search text_field" id="item-author">
                            <?php
                            foreach ($authors as $author)
                                echo '<option value="' , $author->id ,'">' , $author->name ,'</option>';
                            ?>
                        </select>
                    </div>
                </div>
            </div><div class="quark-presence-column right" id="second_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Resume</p>
                        <input placeholder="Resume" type="text" class="quark-input text_field" name="resume" id="item-resume">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Publish Date</p>
                        <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="publishdate" id="item-publish">
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle">
                    <div class="title"><p>Copyright</p>
                        <input placeholder="Copyright" type="text" class="quark-input text_field" name="copyright"  id="item-copyright">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Priority</p>
                        <input placeholder="Priority" type="text" class="quark-input text_field" name="priority" id="item-priority">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Keywords</p>
                        <input placeholder="keywords" type="text" class="quark-input text_field" name="keywords" id="item-keywords">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Description</p>
                        <input placeholder="Description" type="text" class="quark-input text_field" name="description" id="item-description">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Specialization</p>
                        <div class="cm-form-checkbox"><input type="checkbox" name="available_on_site" id="cm-item-available_on_site">On Site</div>
                        <div class="cm-form-checkbox"><input type="checkbox" name="available_on_api" id="cm-item-available_on_api">On Api</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="quark-presence-container presence-block" id="content-container">
            <div class="quark-presence-column form-title">Content</div>
            <br />
            <div class="quark-presence-column form-value">
                <textarea name="txtfield" id="editor-container"></textarea>
            </div>
        </div>
        <br/>
        <div class="quark-presence-container presence-block button-div" >
            <button class="submit-button quark-button block ok" type="submit">
				Create
            </button>
        </div>
    </div>
</form>
