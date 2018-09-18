<?php
use Models\Category;
use Models\Category_has_Photo;
use Models\Category_has_Tag;
use Models\Photo;
use Models\Tag;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Category\CreateView;

/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Category $category
 */
?>
<h1 class="page-title">Update Selected Category</h1>
<h5 class="page-title">Insert data for update selected category</h5>
<form method="POST" id="item-form"  action="/admin/category/edit/<?php echo $category->id; ?>">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
                <input type="hidden" value="<?php echo $category->id;?>" id="cm-category-id">
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Title</p>
						<input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $category->title;?>"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Short Title</p>
						<input placeholder="Short Title" type="text" class="quark-input text_field" name="short_title" id="item-short-title" value="<?php echo $category->short_title;?>"/>
					</div>
				</div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Role</p>
                        <select name="sub" class="quark-input text_field">
                            <option value="<?php echo Category::ROLE_CUSTOM;?>" <?php if ($category->role == Category::ROLE_CUSTOM) echo 'selected';?>>Custom</option>
                            <option value="<?php echo Category::ROLE_SYSTEM;?>" <?php if ($category->role == Category::ROLE_SYSTEM) echo 'selected';?>>System</option>
                        </select>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Type</p>
                        <select name="sub" class="quark-input text_field">
                            <option value="<?php echo Category::TYPE_CATEGORY;?>" <?php if ($category->sub == Category::TYPE_CATEGORY) echo 'selected';?>>Category</option>
                            <option value="<?php echo Category::TYPE_SUBCATEGORY;?>" <?php if ($category->sub == Category::TYPE_SUBCATEGORY) echo 'selected';?>>Sub-Category</option>
                            <option value="<?php echo Category::TYPE_ARCHIVE;?>" <?php if ($category->sub == Category::TYPE_ARCHIVE) echo 'selected';?>>Archive</option>
							<?php
								if ($category->sub == Category::TYPE_SYSTEM_ROOT_CATEGORY)
									echo '<option value="' , Category::TYPE_SYSTEM_ROOT_CATEGORY , '"' , $category->sub == Category::TYPE_SYSTEM_ROOT_CATEGORY ? 'selected' : '' , '>Root Category</option>';

								if ($category->sub == Category::TYPE_SYSTEM_TOP_MENU_CATEGORY)
									echo '<option value="' , Category::TYPE_SYSTEM_TOP_MENU_CATEGORY , '"' , $category->sub == Category::TYPE_SYSTEM_TOP_MENU_CATEGORY ? 'selected' : '' , '>Top Menu Category</option>';

								if ($category->sub == Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY)
									echo '<option value="' , Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY , '"' , $category->sub == Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY ? 'selected' : '' , '>Main Menu Category</option>';

								if ($category->sub == Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY)
									echo '<option value="' , Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY , '"' , $category->sub == Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY ? 'selected' : '' , '>Bottom Menu Category</option>';
							?>
                        </select>
                    </div>
                </div>
			</div><div class="quark-presence-column left" id="second_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Note</p>
                        <input placeholder="Note" type="text" class="quark-input text_field" name="note" id="item-note" value="<?php echo $category->note; ?>"/>
                    </div>
                </div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Priority</p>
						<input placeholder="Priority" type="text" class="quark-input text_field" name="priority" id="item-priority" value="<?php echo $category->priority; ?>"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Keywords</p>
						<input type="text" placeholder="Type" class="quark-input text_field" name="keywords" id="item-keywords" value="<?php echo $category->keywords; ?>"/>
					</div>
				</div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Specialization</p>
                        <div class="cm-form-checkbox"><input type="checkbox" name="available_on_site" id="cm-item-available_on_site" value="<?php echo $category->available_on_site;?>">On Site</div>
                        <div class="cm-form-checkbox"><input type="checkbox" name="available_on_api" id="cm-item-available_on_api" value="<?php echo $category->available_on_api;?>">On Api</div>
                        <div class="cm-form-checkbox"><input type="checkbox" name="master" id="cm-item-master" value="<?php echo $category->master;?>">Master</div>
                    </div>
                </div>
			</div>
		</div>
		<div class="quark-presence-container presence-block main" id="content-container">
            <div class="quark-presence-container presence-block middle">
                <div class="title"><p>Description</p>
                    <input type="text" PLACEHOLDER="Description" class="quark-input large_text_field" name="description" id="item-description" value="<?php echo $category->description; ?>"/>
                </div>
            </div>
            <div class="quark-presence-container presence-block" id="content-container">
                <input id="form-item-content" name="intro" type="hidden">
                <div class="title"><p>Content</p>
                    <textarea name="intro" id="editor-container"><?php echo $category->intro;?></textarea>
                </div>
            </div>
		</div>
        <br />
        <div class="quark-presence-container presence-block  middle">
            <div class="quark-presence-column form-title">
                Insert Tags
            </div>
            <br />
            <div class="quark-presence-column form-value" id="cm-form-tag-container">
                <input type="text" class="quark-input text_field" id="cm-form-tag-input">
                <button type="button" class="quark-button block ok" id="cm-form-button-add-tag">Add tag</button>
                <br/>
                <br/>
				<?php
				$tags = $category->Tags();

				foreach ($tags as $tag) {
					/**
					 * @var QuarkModel|Tag $tag
					 */
					echo
					'<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" action="/admin/category/tag/unlink/' , Category_has_Tag::GetLink($category, $tag)->id ,'">' ,
					$tag->name ,'  ',
					'<a class="fa fa-close"></a>',
					'</button>';
				}
				?>
            </div>
        </div>
        <br />
        <div class="quark-presence-container presence-block  middle">
            <div class="quark-presence-column form-title">
                Linked Photos
                <h5>List photos that is already linked:</h5>
            </div>
            <br />
            <div class="quark-presence-column form-value" id="cm-form-linked-photo-container">
				<?php
				$existed = array();
				foreach ($category->Photos() as $photo) {
					/**
					 * @var QuarkModel|Photo $photo
					 */
					echo
					'<button type="button" class="cm-button-photo cm-button-sub-item-action" title="Link photo to this category" action="/admin/category/photo/unlink/' , Category_has_Photo::GetLink($category, $photo)->id ,'">' ,
					'<img src="' , $photo->file->WebLocation() , '" class="cm-form-related-photo" >',
					'</button>';

					$existed[] = $photo->id;
				}
				?>
            </div>
        </div>
        <br/>
        <div class="quark-presence-container presence-block  middle">
            <div class="quark-presence-column form-title">
                Link Photos
                <h5> List of photos ready for link, searched by category's tags:</h5>
            </div>
            <br />
            <div class="quark-presence-column form-value" id="cm-form-photo-links-container">
				<?php
				$tags = $category->Tags();
                $photos = new QuarkCollection(new Photo());

				foreach ($tags as $tag)
				    foreach ($tag->Photos() as $photo) {
				        if (in_array($photo->id, $existed))
				            continue;

                        /**
                         * @var QuarkModel|Photo $photo
                         */
                        echo
                        '<button type="button" class="cm-button-photo" title="Link photo to this category" onclick="LinkPhoto(\'category\',', $category->id ,',', $photo->id,', this)">' ,
                            '<img src="' , $photo->file->WebLocation() , '" class="cm-form-related-photo">',
                        '</button>';

                        $existed[] = $photo->id;
				    }
				?>
            </div>
        </div>
        <br />
		<div class="quark-presence-container presence-block button-div">
			<button class="quark-button block ok submit-button" type="submit">Update</button>
            <a class="quark-button block  cm-remove-button item-remove-dialog" quark-dialog="#item-remove" quark-redirect="/admin/category/list/" href="/admin/category/relation/clear/<?php echo $category->id;?>">Delete All Relations</a>
		</div>
	</div>
</form>
<?php
echo $this->Fragment(new QuarkViewDialogFragment(
	'item-remove',
	'Delete category relationships',
	'You are about to delete the category relations with articles and categories. This action cannot be undone. Continue?',
	'Please wait...',
	'The links was deleted',
	'An error occurred. Failed to delete the links',
	'Remove',
	'Close'
));
?>