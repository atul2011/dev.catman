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
<<<<<<< HEAD:Views/Admin/Categories.php
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
=======
    <form action="" method="POST">
    <Div class="quark-presence-container presence-block middle search-bar"id="route-row">

    </Div>
    </form>
    <Div class="quark-presence-container presence-block middle" id="elements-list">
        <div class="items-body quark-presence-column" id="content-container">
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283:Views/Content/Structures/Categories.php

        </div>
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
                <input type="hidden" id="current-number-category" value="">
                <form class="navigation_form">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="first-category"  disabled><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="prev-category" disabled><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_prev-category" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column current-pages-category">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_next-category" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="next-category">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="last-category">>></button>
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
                <input type="hidden" id="current-number-article" value="">
                <form class="navigation_form">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="first-article" ><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="prev-article" ><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_prev-article" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column current-pages-article">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_next-article" disabled>...
                        </button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="next-article">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="last-article" >>></button>
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