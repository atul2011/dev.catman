<?php
/**
 * @var QuarkView|ListView $this
 * @var int $number
 */
use Quark\QuarkView;
use ViewModels\Content\Category\ListView;

?>
<div class="quark-presence-column " id="content-container">
    <div class="quark-presence-container presence-block">
        <form>
            <ul class="search-list" type="none">
                <li><select id="event-select" class="model-select"></select></li>
                <li><input type="text" class="search" name="event-search"
                           placeholder="insert firsts letters of title wich you search"></li>
            </ul>
        </form>
    </div>
    <div class="quark-presence-container presence-block main2 items-list" id="event-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="name" class="quark-presence-column  content-titles names">Name</div>
                <div id="startdate" class="quark-presence-column  content-titles dates">Start Date</div>
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
                    <form action="/event/create" method="GET">
                        <input type="hidden" name="url" id="url">
                        <button type="submit" class=" button-add">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>