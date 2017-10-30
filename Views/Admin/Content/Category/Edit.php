<?php
use Models\Category;
use Models\Tag;
	use Quark\Quark;
	use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Content\Category\CreateView;

/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Category $category
 * @var QuarkCollection|Tag[] $tags
 */
 Quark::Trace($category);
?>
<h2 class="page-title">Update Selected Category</h2>
<h5>Insert data for update selected category</h5>
<form method="POST" id="item-form"  action="/admin/category/edit/<?php echo $category->id; ?>">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>Title</p>
						<input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $category->title; ?>"/>
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
                            <option value="<?php echo Category::TYPE_CATEGORY;?>" <?php if ($category->type == Category::TYPE_CATEGORY) echo 'selected';?>>Category</option>
                            <option value="<?php echo Category::TYPE_SUBCATEGORY;?>" <?php if ($category->type == Category::TYPE_SUBCATEGORY) echo 'selected';?>>Sub-Category</option>
							<?php
								if (Category::RootCategory()->id ==  $category->id)
									echo '<option value="' , Category::TYPE_SYSTEM_ROOT_CATEGORY , '"' , $category->type == Category::TYPE_SYSTEM_ROOT_CATEGORY ? 'selected' : '' , '>Root Category</option>';

								if (Category::TopMenuCategory()->id ==  $category->id)
									echo '<option value="' , Category::TYPE_SYSTEM_TOP_MENU_CATEGORY , '"' , $category->type == Category::TYPE_SYSTEM_TOP_MENU_CATEGORY ? 'selected' : '' , '">Top Menu Category</option>';

								if (Category::MainMenuCategory()->id ==  $category->id)
									echo '<option value="' , Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY , '"' , $category->type == Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY ? 'selected' : '' , '">Main Menu Category</option>';

								if (Category::BottomMenuCategory()->id ==  $category->id)
									echo '<option value="' , Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY , '"' , $category->type == Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY ? 'selected' : '' , '">Bottom Menu Category</option>';
							?>
                        </select>
                    </div>
                </div>
			</div><div class="quark-presence-column right" id="second_div">
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
			</div>
		</div>
		<div class="quark-presence-container presence-block main" id="content-container">
            <div class="quark-presence-container presence-block middle">
                <div class="title"><p>Description</p>
                    <input type="text" PLACEHOLDER="Description" class="quark-input large_text_field" name="description" id="item-description" value="<?php echo $category->description; ?>"/>
                </div>
            </div>
			<div class="title"><p>Tags</p>
				<input type="text" placeholder="Tags, divided by [,]" class="large_text_field quark-input" name="tag_list" id="item-tags" value="<?php foreach ($tags as $tag) echo $tag->name . ',';?>">
			</div>
			<div class="title"><p>Content</p>
				<textarea placeholder="Content" class="content quark-input" name="intro" id="item-intro">
                        <?php echo $category->intro; ?>
                    </textarea>
			</div>
		</div>
		<div class="quark-presence-container presence-block button-div">
			<br/>
			<button class="quark-button block ok submit-button" type="submit">
				Update
			</button>
		</div>
	</div>
</form>