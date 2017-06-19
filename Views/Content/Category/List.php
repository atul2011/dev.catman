<div class="quark-presence-column " id="content-container">
    <div class="quark-presence-container presence-block">
        <form action="/category/search" method="POST">
            <ul class="search-list" type="none">
                <li><input type="checkbox" name="orfan" class="orfan" id="category">No parents</li>
                <li><select id="category-select" class="model-select"></select></li>
                <li><input type="text" class="search" name="category-search"
                           placeholder="insert firsts letters of title wich you search"></li>
            </ul>
        </form>
    </div>
    <div class="quark-presence-container presence-block main2 items-list" id="category-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="title" class="quark-presence-column  content-titles titles">Title</div>
                <div id="Type" class="quark-presence-column  content-titles types">Type</div>
                <div id="txtfield" class="quark-presence-column  content-titles contents">Content</div>
                <div id="redaction" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column">
            <div class="quark-presence-container presence-block" id="nav-bar">
                <form action="" class="navigation_form" method="GET">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="first" value="1"><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="prev"><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_prev">...</button>
                    </div>
                    <div class="quark-presence-column current-pages">
                    </div>
                    <div class="quark-presence-column">
                        <button class="nav-button space_buttons" id="space_next">...</button>
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
                    <form action="/category/create" method="GET">
                        <input type="hidden" name="url" id="url">
                        <button type="submit" class=" button-add" onclick="return seturl()">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>