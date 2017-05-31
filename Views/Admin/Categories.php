<?php
/**
 * @var QuarkView|CategoriesView $this
 */
use ViewModels\Admin\CategoriesView;
use Quark\QuarkView;

?>
<div class="quark-presence-column left tables-container" id="list-left">
    <Div class="quark-presence-container presence-block main search-bar">
        <form action="" method="POST">
            <table id="route">
                <tr id="route-row">
                </tr>
            </table>
        </form>
    </Div>
    <Div class="quark-presence-container presence-block main" id="elements-list">
        <table class="items-body" id="content-container">

        </table>
    </Div>
</div>

<!--butons-->
<div class="quark-presence-column center buttons-list" id="list-center">
    <table class="buttons">
        <tr>
            <td>
                <form onsubmit="Link('category','category')" class="submit-buttons">
                    <button name="link-category" id="category-link" class="" type="submit"></button>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form onsubmit="Link('article','article')" class="submit-buttons">
                    <button name="link-article" id="article-link" class="" type="submit"></button>
                </form>
            </td>
        </tr>
    </table>
</div>
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
                <th id="id" class="category-titles">ID</th>
                <th id="title" class="category-titles">Title</th>
                <th id="sub" class="category-titles">Type of</th>
                <th id="intro" class="category-titles">Content</th>
                <th id="redaction" class="category-titles">Actions</th>
            </tr>
        </table>
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
                <th id="id" class="articles-titles">ID</th>
                <th id="title" class="articles-titles">Title</th>
                <th id="release_date" class="articles-titles">Release</th>
                <th id="txtfield" class="articles-titles">Content</th>
                <th id="redaction" class="articles-titles">Actions</th>
            </tr>
        </table>
    </div>
</div>