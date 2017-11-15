<?php
/**
 * @var QuarkView|CategoriesView $this
 * @var int $number_categories
 * @var int $number_articles
 */

use Models\Category;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Content\Structures\CategoriesView;
use Quark\QuarkView;

echo $this->Fragment(new QuarkViewDialogFragment(
	                     'item-remove',
	                     'Delete item',
	                     'You are about to delete the item. This action cannot be undone. Continue?',
	                     'Please wait...',
	                     'The item was deleted',
	                     'An error occurred. Failed to delete the item',
	                     'Remove',
	                     'Close'
                     ));
?>
<h2>Categories Structure</h2>
<h5>Set for each category his own sub-category and articles</h5>
<div class="quark-presence-column center tables-container" id="list-left">
    <form action="" method="POST">
    <div class="quark-presence-container presence-block middle search-bar" id="route-row">
        <?php if (Category::RootCategory() != null) ?>
    </div>
    </form>
    <Div class="quark-presence-container presence-block middle" id="elements-list">
        <div class="items-body quark-presence-column" id="content-container"></div>
    </Div>
</div>
<div class="quark-presence-column center buttons-list" id="list-center">
    <div class="quark-presence-container" id="button-link-category">
        <form onsubmit="Link('category');" class="submit-buttons">
            <button name="link-category" id="category-link" class="" type="submit"></button>
        </form>
    </div>
    <div class="quark-presence-container" id="button-link-article">
        <form onsubmit="Link('article');" class="submit-buttons">
            <button name="link-article" id="article-link" class="" type="submit"></button>
        </form>
    </div>
</div>
<div class="quark-presence-column center tables-container" id="list-right">
    <div class="quark-presence-container presence-block main">
        <form>
            <div class="quark-presence-column list-options">
                <input type="checkbox" name="orfan" class="orfan" id="category-orfan">No parents
            </div>
            <div class="quark-presence-column list-options">
                <select id="category-select" class="model-select"></select>
            </div>
            <div class="quark-presence-column list-options">
                <input type="text" class="search" name="name" id="category-search"
                       placeholder="insert firsts letters of title wich you search">
            </div>
        </form>
    </div>
    <div class="quark-presence-container presence-block main items-list " id="category-list">
        <div class="quark-presence-column" id="category-column">
            <div class="quark-presence-container presence-block category-head" id="list-content">
                <div id="ID" class="quark-presence-column category-titles ids">ID
                </div><div id="title" class="quark-presence-column  category-titles titles">Title
                </div><div id="Type" class="quark-presence-column  category-titles types">Type
                </div><div id="redaction" class="quark-presence-column  category-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle-category"></div>
        </div>
    </div>
    <div class="quark-presence-container presence-block navigation-container">
        <div class="quark-presence-column left">
            <div class="quark-presence-container presence-block" id="nav-bar-category">
                <input type="hidden" id="number-category" value="<?php echo $number_categories; ?>">
                <input type="hidden" id="current-number-category" value="">
                <form class="navigation_form">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-first-category"  disabled><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-prev-category" disabled><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="navbutton-space_prev-category" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column current-pages-category">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="navbutton-space_next-category" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-next-category">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-last-category">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <a href="/admin/category/create/">
                        <button type="submit" class="btn btn-success pull-right btn-xs">
                            Add new
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <hr class="delimitator"/>
    <div class="quark-presence-container presence-block">
        <form>
            <div class="quark-presence-column list-options">
                <input type="checkbox" name="orfan" class="orfan" id="article-orfan">No parents
            </div>
            <div class="quark-presence-column list-options">
                <select id="article-select" class="model-select"></select>
            </div>
            <div class="quark-presence-column list-options">
                <input type="text" class="search" name="name" id="article-search"
                       placeholder="insert firsts letters of title wich you search">
            </div>

        </form>
    </div>
    <div class="quark-presence-container presence-block main items-list" id="article-list">
        <div class="quark-presence-column" id="article-column">
            <div class="quark-presence-container presence-block article-head">
                <div id="ID" class="quark-presence-column article-titles ids">ID
                </div><div id="title" class="quark-presence-column  article-titles titles">Title
                </div><div id="release_date" class="quark-presence-column  article-titles dates">Release
                </div><div id="redaction" class="quark-presence-column  article-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle-article"></div>
        </div>
    </div>
    <div class="presence-block quark-presence-container navigation-container">
        <div class="quark-presence-column left">
            <div class="quark-presence-container presence-block" id="nav-bar-article">
                <input type="hidden" id="number-article" value="<?php echo $number_articles; ?>">
                <input type="hidden" id="current-number-article" value="">
                <form class="navigation_form">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-first-article" ><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-prev-article" ><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="navbutton-space_prev-article" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column current-pages-article">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="navbutton-space_next-article" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-next-article">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="navbutton-last-article" >>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <a href="/admin/article/create">
                        <button type="submit" class="btn btn-success pull-right btn-xs">
                            Add new
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>