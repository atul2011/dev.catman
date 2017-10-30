<?php
/**
 * @var QuarkView|ListView $this
 * @var int $number
 */
use Quark\QuarkView;
use ViewModels\Admin\Content\Category\ListView;
?>
<h2 class="page-title">News List</h2>
<h5>Navigate through news</h5>
<div class="quark-presence-column " id="content-container">
	<div class="quark-presence-container presence-block">
		<div class="quark-presence-column search-list">
			<select id="news-select" class="field-select"></select>
		</div>
		<div class="quark-presence-column search-list">
			<input type="text" class="search" name="news-search" placeholder="insert firsts letters of title wich you search">
		</div>
	</div>
	<div class="quark-presence-container presence-block main2 items-list" id="news-list">
		<div class="quark-presence-column" id="content-column">
			<div class="quark-presence-container presence-block" id="list-content">
				<div id="item-title-id" class="quark-presence-column content-titles ids">ID</div>
				<div id="item-title-title" class="quark-presence-column  content-titles titles">Title</div>
				<div id="item-title-type" class="quark-presence-column  content-titles types">Type</div>
				<div id="item-title-text" class="quark-presence-column  content-titles contents">Content</div>
				<div id="item-title-user" class="quark-presence-column  content-titles users">User ID</div>
				<div id="item-title-date" class="quark-presence-column  content-titles dates">Edit Date</div>
				<div id="item-title-redaction" class="quark-presence-column  content-titles actions">Actions</div>
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
					<form action="/admin/news/create" method="GET">
						<button type="submit" class=" button-add">+</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>