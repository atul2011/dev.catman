<?php
/**
 * @var QuarkView|ListView $this
 * @var int $number
 */
use Quark\QuarkView;
use ViewModels\Admin\Content\Category\ListView;

?>
<div class="quark-presence-column " id="content-container">
    <div class="quark-presence-container presence-block">
                <div class="quark-presence-column search-list">
                    <select id="author-select" class="model-select"></select>
                </div>
                <div class="quark-presence-column search-list">
                    <input type="text" class="search" name="author-search" placeholder="insert firsts letters of title wich you search">
                </div>
    </div>
    <div class="quark-presence-container presence-block main2 items-list" id="author-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="name" class="quark-presence-column  content-titles names">Name</div>
                <div id="type" class="quark-presence-column  content-titles types">Type</div>
                <div id="keywords" class="quark-presence-column  content-titles keywords">Keywords</div>
                <div id="actions" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle"></div>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column">
            <div class="quark-presence-container presence-block" id="nav-bar">
                <form action="" class="navigation_form" method="GET">
                    <input type="hidden" id="number" value="<?php echo $number; ?>">
                    <input type="hidden" id="current-number" value="">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="first" value="1"><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="prev"><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_prev" disabled>...</button>
                    </div>
                    <div class="quark-presence-column current-pages">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_next" disabled>...</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="next">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="last" value="0">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <form action="/admin/author/create" method="GET">
                        <input type="hidden" name="url" id="url">
                        <button type="submit" class="button-add">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>