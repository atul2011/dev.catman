<?php
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Category\ListView;

/**
 * @var QuarkView|ListView $this
 * @var int $number
 */
?>
<h1 class="page-title">Categories List</h1>
<h5 class="page-title">Navigate through categories</h5>
<div class="quark-presence-column left" id="content-container">
    <div class="quark-presence-container presence-block">
        <div class="quark-presence-column search-list">
            <input type="checkbox" name="orfan" class="orfan" id="category-orfan">No parents
        </div>
        <div class="quark-presence-column search-list">
            <select id="category-select" class="quark-input field-select"></select>
        </div>
        <div class="quark-presence-column search-list">
            <input type="text" class="quark-input search" name="category-search" placeholder="insert firsts letters of title wich you search">
        </div>
    </div>
    <div class="quark-presence-container presence-block main2 items-list" id="category-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="title" class="quark-presence-column  content-titles titles">Title</div>
                <div id="Type" class="quark-presence-column  content-titles types">Type</div>
                <div id="redaction" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle"></div>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column">
            <div class="quark-presence-container presence-block" id="navbutton-nav-bar">
                <form action="" class="navigation_form" method="GET">
                    <input type="hidden" id="number" value="<?php echo $number; ?>">
                    <input type="hidden" id="current-number" value="">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-first"><<</button>
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
                        <button type="submit" class="nav-button" id="navbutton-last">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <form action="/admin/category/create" method="GET">
                        <button type="submit" class=" button-add">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Fragment(new QuarkViewDialogFragment(
	'item-remove',
	'Delete category',
	'You are about to delete the category. This action cannot be undone. Continue?',
	'Please wait...',
	'The category was deleted',
	'An error occurred. Failed to delete the category',
	'Remove',
	'Close'
));
?>