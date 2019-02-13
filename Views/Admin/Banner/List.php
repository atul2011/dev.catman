<?php
/**
 * @var QuarkView|ListView $this
 * @var int $number
 */

use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Banner\ListView;
?>
<h1 class="page-title">Banner List</h1>
<h5 class="page-title">Navigate through banners</h5>
<div class="quark-presence-column left" id="content-container">
	<div class="quark-presence-container presence-block">
		<div class="quark-presence-column search-list">
			<select id="banner-select" class="quark-input field-select"></select>
		</div>
		<div class="quark-presence-column search-list">
			<input type="text" class="quark-input search" name="banner-search" placeholder="insert firsts letters of title wich you search">
		</div>
	</div>
	<div class="quark-presence-container presence-block main2 items-list" id="banner-list">
		<div class="quark-presence-column" id="content-column">
			<div class="quark-presence-container presence-block" id="list-content">
				<div id="ID" class="quark-presence-column content-titles ids">ID</div>
				<div id="File" class="quark-presence-column  content-titles files">File</div>
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
						<button type="submit" class="nav-button" id="navbutton-first" value="1"><<</button>
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
						<button type="submit" class="nav-button" id="navbutton-last" value="0">>></button>
					</div>
				</form>
			</div>
		</div>
		<div class="quark-presence-column right">
			<div class="quark-presence-container button-div" id="form-add-button">
				<div class="quark-presence-column right button-add-column" id="button-add-column">
					<form action="/admin/banner/create" method="GET">
						<button type="submit" class=" button-add">+</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Fragment(new QuarkViewDialogFragment(
	'item-remove',
	'Delete banner',
	'You are about to delete the banner. This action cannot be undone. Continue?',
	'Please wait...',
	'The banner was deleted',
	'An error occurred. Failed to delete the banner',
	'Remove',
	'Close'
));
?>