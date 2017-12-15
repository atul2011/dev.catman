<?php
/**
 * @var QuarkView|CreateView $this
 */
use Models\Category;
use Quark\Quark;
use Quark\QuarkView;
use ViewModels\Admin\Category\CreateView;
?>
<h1 class="page-title">Add New Category</h1>
<h5 class="page-title">Insert data to create an new category</h5>
<form method="POST" id="item-form"  action="/admin/category/create">
    <div class="quark-presence-column content-column left">
        <div class="quark-presence-container content-container  main">
            <div class="quark-presence-column left" id="main_div">
                <div class="quark-presence-container presence-block  middle">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle">
                    <div class="title"><p>Short Title</p>
                        <input placeholder="Short Title" type="text" class="quark-input text_field" name="short_title" id="item-short-title"/>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Role</p>
                        <select name="sub" class="quark-input text_field">
                            <option value="<?php echo Category::ROLE_CUSTOM;?>">Custom</option>
                            <option value="<?php echo Category::ROLE_SYSTEM;?>">System</option>
                        </select>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Type</p>
                        <select name="sub" class="quark-input text_field">
                            <option value="<?php echo Category::TYPE_CATEGORY;?>">Category</option>
                            <option value="<?php echo Category::TYPE_SUBCATEGORY;?>">Sub-Category</option>
                            <option value="<?php echo Category::TYPE_ARCHIVE;?>">Archive</option>
                            <?php

                            if (Category::RootCategory() == null)
                                echo '<option value="' , Category::TYPE_SYSTEM_ROOT_CATEGORY , '">Root Category</option>';

                            if (Category::TopMenuCategory() == null)
                                echo '<option value="' , Category::TYPE_SYSTEM_TOP_MENU_CATEGORY , '">Top Menu Category</option>';

                            if (Category::MainMenuCategory() == null)
                                echo '<option value="' , Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY , '">Main Menu Category</option>';

                            if (Category::BottomMenuCategory() == null)
                                echo '<option value="' , Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY , '">Bottom Menu Category</option>';
                            ?>
                        </select>
                    </div>
                </div>
            </div><div class="quark-presence-column right" id="second_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note"/>
                    </div>
                </div>
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
            </div>
        </div>
        <div class="quark-presence-container presence-block main" id="content-container">
            <div class="quark-presence-container presence-block middle">
                <div class="title"><p>Description</p>
                    <input type="text" PLACEHOLDER="Description" class="quark-input large_text_field" name="description" id="item-description"/>
                </div>
            </div>
            <div class="title"><p>Tags</p>
                <input type="text" placeholder="Tags, divided by [,]" class="quark-input large_text_field" name="tag_list" id="item-tags">
            </div>
            <div class="quark-presence-container presence-block" id="content-container">
                <input id="form-item-content" name="intro" type="hidden">
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
                    <div id="editor-container"></div>
                </div>
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