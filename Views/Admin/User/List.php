<?php
use Models\User;
use Quark\QuarkModel;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\User\ListView;
/**
 * @var QuarkView|ListView $this
 * @var QuarkModel|User $users
 * @var int $number
 */
?>
<h1 class="page-title">User List</h1>
<h5 class="page-title">Navigate through users</h5>
<div class="quark-presence-column left" id="content-container">
	<div class="quark-presence-container presence-block">
		<form>
			<ul class="search-list" type="none">
				<li><select id="user-select" class="quark-input model-select"></select></li>
				<li><input type="text" class="quark-input search" name="user-search"
						   placeholder="insert firsts letters of username wich you search"></li>
			</ul>
		</form>
	</div>
	<div class="quark-presence-container presence-block main4 items-list" id="user-list">
		<div class="quark-presence-column" id="content-column">
			<div class="quark-presence-container presence-block" id="list-content">
				<div id="ID" class="quark-presence-column content-titles ids">ID</div>
				<div id="login" class="quark-presence-column  content-titles logins">Login</div>
				<div id="name" class="quark-presence-column  content-titles names">Name</div>
				<div id="email" class="quark-presence-column  content-titles emails">Email</div>
				<div id="rights" class="quark-presence-column  content-titles rights">Rights</div>
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
					<input type="hidden" id="number" value="<?php echo $number;?>">
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
					<form action="/admin/user/create" method="GET">
						<button type="submit" class="button-add">+</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Fragment(new QuarkViewDialogFragment(
	'item-remove',
	'Delete item',
	'You are about to delete the item. This action cannot be undone. Continue?',
	'Please wait...',
	'The item was deleted',
	'An error occurred. Failed to delete the item',
	'Remove',
	'Close'
));
?>