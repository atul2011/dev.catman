<?php
/**
 * @var QuarkView|CreateView $this
 */
use Quark\QuarkView;
use ViewModels\Admin\Content\Category\CreateView;

?>
<h1 class="page-title">Add new Category</h1>
<form method="POST" id="item-form"  action="/admin/category/create">
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
                        <input type="text" placeholder="Type" maxlength="1" class="quark-input text_field" name="sub" id="item-sub"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note"/>
                    </div>
                </div>
            </div><div class="quark-presence-column right" id="second_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Priority</p>
                        <input placeholder="Priority" type="text" class="quark-input text_field" name="priority" id="item-priority"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Keywords</p>
                        <input type="text" placeholder="Type" class="quark-input text_field" name="keywords" id="item-keywords"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Description</p>
                        <input type="text" PLACEHOLDER="Description" class="quark-input text_field" name="description" id="item-description"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="quark-presence-container presence-block main" id="content-container">
            <div class="title"><p>Tags</p>
                <input type="text" placeholder="Tags, divided by [,]" class="large_text_field quark-input" name="tag_list" id="item-tags">
            </div>
            <div class="title"><p>Content</p>
                <textarea placeholder="Content" class="content quark-input" name="intro" id="item-intro"></textarea>
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