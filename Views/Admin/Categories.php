<?php
/**
 * @var QuarkView|CategoriesView $this
<<<<<<< HEAD
=======
 * @var int $number_categories
 * @var int $number_articles
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
 */
use ViewModels\Admin\CategoriesView;
use Quark\QuarkView;

?>
<<<<<<< HEAD
<div class="quark-presence-column left tables-container" id="list-left">
    <Div class="quark-presence-container presence-block main search-bar">
=======
<div class="quark-presence-column center tables-container" id="list-left">
    <Div class="quark-presence-container presence-block middle search-bar">
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
        <form action="" method="POST">
            <table id="route">
                <tr id="route-row">
                </tr>
            </table>
        </form>
    </Div>
<<<<<<< HEAD
    <Div class="quark-presence-container presence-block main" id="elements-list">
=======
    <Div class="quark-presence-container presence-block middle" id="elements-list">
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
        <table class="items-body" id="content-container">

        </table>
    </Div>
</div>

<<<<<<< HEAD
<!--butons-->
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
<div class="quark-presence-column center buttons-list" id="list-center">
    <table class="buttons">
        <tr>
            <td>
<<<<<<< HEAD
                <form onsubmit="Link('category','category')" class="submit-buttons">
=======
                <form onsubmit="Link('category');" class="submit-buttons">
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
                    <button name="link-category" id="category-link" class="" type="submit"></button>
                </form>
            </td>
        </tr>
        <tr>
            <td>
<<<<<<< HEAD
                <form onsubmit="Link('article','article')" class="submit-buttons">
=======
                <form onsubmit="Link('article');" class="submit-buttons">
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
                    <button name="link-article" id="article-link" class="" type="submit"></button>
                </form>
            </td>
        </tr>
    </table>
</div>
<<<<<<< HEAD
<!--items-->

<div class="quark-presence-column right tables-container" id="list-right">
    <!--    categories-->
    <form action="/category/search" method="POST">
        <ul class="search-list">
            <li><input type="checkbox" name="orfan" class="orfan" id="category">No parents</li>
            <li><input type="text" class="search" name="category-search" id="categories"
                       placeholder="insert firsts letters of title wich you search"></li>
        </ul>
    </form>
    <div class="quark-presence-container presence-block main items-list " id="category-list">

        <table id="category-container" class="items-body" cellpadding="3px" cellspacing="0px">
            <tr>
                <th id="id" class="category-titles titles">ID</th>
                <th id="title" class="category-titles titles">Title</th>
                <th id="sub" class="category-titles titles">Type of</th>
                <th id="intro" class="category-titles titles">Content</th>
                <th id="redaction" class="category-titles titles">Actions</th>
            </tr>
        </table>
    </div>
    <div>
        <a href="/category/create/"><button type="submit" class="btn btn-success pull-right btn-xs">
                Add new
            </button></a>
    </div>
    <br>
    <!--articles-->
    <form action="/articles/search" method="POST">
        <ul class="search-list" type="none">
            <li><input type="checkbox" name="orfan" class="orfan" id="article">No parents</li>
            <li><input type="text" class="search" name="article-search" id="articles"
                       placeholder="insert firsts letters of title wich you search"></li>
        </ul>
    </form>
    <div class="quark-presence-container presence-block main items-list" id="article-list">
        <table id="articles-container" class="items-body" cellpadding="3px" cellspacing="0px">
            <tr>
                <th id="id" class="articles-titles titles">ID</th>
                <th id="title" class="articles-titles titles">Title</th>
                <th id="release_date" class="articles-titles titles">Release</th>
                <th id="txtfield" class="articles-titles titles">Content</th>
                <th id="redaction" class="articles-titles titles">Actions</th>
            </tr>
        </table>
    </div>
    <div>
        <a href="/article/create"><button type="submit" class="btn btn-success pull-right btn-xs">
                Add new
            </button></a>
=======

<div class="quark-presence-column center tables-container" id="list-right">
    <div class="quark-presence-container presence-block main">
        <form>
            <div class="quark-presence-column list-options">
                <input type="checkbox" name="orfan" class="orfan" id="category">No parents
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
                </div><div id="txtfield" class="quark-presence-column  category-titles contents">Content
                </div><div id="redaction" class="quark-presence-column  category-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle-category"></div>
        </div>
    </div>
    <div class="quark-presence-container presence-block navigation-container">
        <div class="quark-presence-column left">
            <div class="quark-presence-container presence-block" id="nav-bar-category">
                <input type="hidden" id="number-category" value="<?php echo $number_categories; ?>">
                <form class="navigation_form">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-category" id="first" value="1"><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-category" id="prev"><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons nav-button-category" id="space_prev" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column current-pages-category">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons nav-button-category" id="space_next" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-category" id="next">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-category" id="last" value="0">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <a href="/category/create/">
                        <button type="submit" class="btn btn-success pull-right btn-xs">
                            Add new
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <div class="quark-presence-container presence-block">
        <form>
            <div class="quark-presence-column list-options">
                <input type="checkbox" name="orfan" class="orfan" id="article">No parents
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
                </div><div id="txtfield" class="quark-presence-column  article-titles contents">Content
                </div><div id="redaction" class="quark-presence-column  article-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle-article"></div>
        </div>
    </div>
    <div class="presence-block quark-presence-container navigation-container">
        <div class="quark-presence-column left">
            <div class="quark-presence-container presence-block" id="nav-bar-article">
                <input type="hidden" id="number-article" value="<?php echo $number_articles; ?>">
                <form class="navigation_form">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-article" id="first" value="1"><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-article" id="prev"><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons nav-button-article" id="space_prev" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column current-pages-article">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons nav-button-article" id="space_next" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-article" id="next">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button nav-button-article" id="last" value="0">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <a href="/article/create">
                        <button type="submit" class="btn btn-success pull-right btn-xs">
                            Add new
                        </button>
                    </a>
                </div>
            </div>
        </div>
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
    </div>
</div>