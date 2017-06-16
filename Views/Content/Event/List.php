<div class="quark-presence-column " id="content-container">
	<div class="quark-presence-container presence-block">
		<form action="/events/search" method="POST">
			<ul class="search-list" type="none">
				<li><input type="text" class="search" name="event-search" placeholder="insert firsts letters of title wich you search"></li>
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
		</div>
	</div>
    <div class="quark-presence-container" id="form-add-button">
        <div class="quark-presence-column right button-add-column" id="button-add-column">
            <form action="/event/create" method="GET">
                <input type="hidden" name="url" id="url">
                <button type="submit" class=" button-add" onclick="return seturl()">+</button>
            </form>
        </div>
    </div>
</div>
