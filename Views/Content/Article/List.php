<div class="quark-presence-column " id="content-container">
    <div class="quark-presence-container presence-block">
        <form action="/articles/search" method="POST">
            <ul class="search-list" type="none">
                <li><input type="checkbox" name="orfan" class="orfan" id="article">No categories linked</li>
                <li><select id="article-select" class="model-select"></select></li>
                <li><input type="text" class="search" name="article-search"
                           placeholder="insert firsts letters of title wich you search"></li>
            </ul>
        </form>
    </div>
    <div class="quark-presence-container presence-block main2 items-list" id="article-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="title" class="quark-presence-column  content-titles titles">Title</div>
                <div id="release_date" class="quark-presence-column  content-titles dates">Release</div>
                <div id="event" class="quark-presence-column  content-titles events">Event</div>
                <div id="txtfield" class="quark-presence-column  content-titles contents">Content</div>
                <div id="redaction" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column">
            <div class="quark-presence-container presence-block" id="nav-bar">
                <form action="/article/next">
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="first" value="0"><<</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="prev" value="-50"><</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="nothing_prev" value="-">...</button>
                    </div>
                    <div class="quark-presence-column current-pages">
                        <div class="quark-presence-column">
                            <button type="submit" class="nav-button">...</button>
                        </div>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="nothing_next" value="-">...</button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="next" value="+50">></button>
                    </div>
                    <div class="quark-presence-column">
                        <button type="submit" class="nav-button" id="last" value="">>></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <form action="/article/create" method="GET">
                        <input type="hidden" name="url" id="url">
                        <button type="submit" class=" button-add" onclick="return seturl()">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
