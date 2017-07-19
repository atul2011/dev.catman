<?php
/**
 * @var QuarkView|CreateView $this
 */

use Quark\QuarkView;
use ViewModels\Admin\Content\Article\CreateView;
?>
<h1 class="page-title">Add new Article</h1>
<form method="POST" id="item-form"action="/admin/article/create">
    <div class="quark-presence-column content-column left">
        <div class="quark-presence-container content-container  main">
            <div class="quark-presence-column left" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Release Date</p>
                        <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="release_date" id="item-release">
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle">
                    <div class="title"><p>Type</p>
                        <input placeholder="Type" type="text" class="quark-input text_field" name="type" id="item-type">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="event-field">
                    <div class="title"><p>Event Name</p>
                        <input placeholder="Event Name" list="eventlist" type="text" class="quark-input search text_field" autocomplete="on" name="event" id="item-event"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="author-field">
                    <div class="title"><p>Author Name</p>
                        <input placeholder="Author name" list="authorlist" type="text"  class="quark-input search text_field" autocomplete="on" name="author" id="item-author"/>
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
                        <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="publish_date" id="item-publish">
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
            </div>
        </div>
        <div class="quark-presence-container presence-block" id="content-container">
            <div class="title"><p>Tags</p>
                <input type="text" placeholder="Tags, divided by [,]" class="large_text_field quark-input" name="tag_list" id="item-tags">
            </div>
            <div class="title"><p>Content</p>
                <textarea placeholder="Content" class="content quark-input" name="txtfield" id="txtfield"></textarea>
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