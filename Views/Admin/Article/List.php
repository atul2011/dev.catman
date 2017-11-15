<?php
/**
 * @var QuarkView|ListView $this
 * @var int $number
 */
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Content\Category\ListView;

echo $this->Fragment(new QuarkViewDialogFragment(
	                     'item-remove',
	                     'Delete article',
	                     'You are about to delete the article. This action cannot be undone. Continue?',
	                     'Please wait...',
	                     'The article was deleted',
	                     'An error occurred. Failed to delete the article',
	                     'Remove',
	                     'Close'
                     ));
?>
<h1 class="page-title">Article List</h1>
<h5 class="page-title">Navigate through articles</h5>
<div class="quark-presence-column " id="content-container">
    <div class="quark-presence-container presence-block">
                <div class="quark-presence-column search-list">
                    <input type="checkbox" name="orfan" class="orfan" id="article-orfan">No categories linked
                </div>
                <div class="quark-presence-column search-list">
                    <select id="article-select" class="quark-input field-select"></select>
                </div>
                <div class="quark-presence-column search-list">
                    <input type="text" class="quark-input search" name="article-search" placeholder="insert firsts letters of title wich you search">
                </div>
    </div>
    <div class="quark-presence-container presence-block main2 items-list" id="article-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="title" class="quark-presence-column  content-titles titles">Title</div>
                <div id="release_date" class="quark-presence-column  content-titles dates">Release</div>
                <div id="event" class="quark-presence-column  content-titles events">Event</div>
                <div id="redaction" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle"></div>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column">
            <div class="quark-presence-container presence-block" id="nav-bar">
                <input type="hidden" id="number" value="<?php echo $number; ?>">
                <input type="hidden" id="current-number" value="">
                <form action="" class="navigation_form" method="GET">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-first" value="1"><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-prev"><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="navbutton-space_prev" disabled>...</button>
                    </div>
                    <div class="quark-presence-column current-pages">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="navbutton-space_next" disabled>...</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-next">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-last" value="0">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <form action="/admin/article/create" method="GET">
                        <button type="submit" class=" button-add" >+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>