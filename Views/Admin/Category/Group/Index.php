<?php
use Models\Category;
use Models\CategoryGroup;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Category\Group\IndexView;
/**
 * @var QuarkView|IndexView $this
 * @var QuarkModel|Category $category
 */
?>
<div class="quark-presence-column left page-content">
	<h1 class="page-title">Edit Category "<?php echo $category->title;?>" Groups</h1>
	<input type="hidden" id="current_category_id" value="<?php echo $category->id;?>">
	<div class="quark-presence-column left page-content-column">
		<h3 class="page-sequence-title">List of Category Childes</h3>
		<div class="quark-presence-column" id="category-links-container" data-draggable="target" data-draggable-type="drop" action="unlink">
		</div>
	</div>
	<div class="quark-presence-column left page-content-column">
		<h3 class="page-sequence-title">List of Category Groups</h3>
		<div class="quark-presence-column" id="category-groups-container" data-draggable="target" data-draggable-type="drop">
			<div class="page-button-add" id="category-group-add">Add New Group</div>
		</div>
	</div>
</div>
