<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Banner $banner
 */
use Models\Banner;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Banner\CreateView;
?>
<h1 class="page-title">Edit Existing Banner</h1>
<h5 class="page-title">Insert data for update selected banner</h5>
<form enctype="multipart/form-data" method="POST" id="item-form"  action="/admin/banner/edit/<?php echo $banner->id;?>">
	<div class="quark-presence-column content-column left">
		<div class="quark-presence-container content-container  main">
			<div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block  middle">
					<div class="title"><p>File</p>
						<input type="file" class="quark-input text_field" name="file" id="item-file"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Active</p>
						<input type="text" value="<?php echo $banner->active;?>" placeholder="Is Active(1 or 0)" maxlength="1" class="quark-input text_field" name="active" id="item-active"/>
					</div>
				</div>
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Link</p>
						<input type="text" value="<?php echo $banner->link;?>" placeholder="link that will be accessed on click on banner" class="quark-input text_field" name="link" id="item-link"/>
					</div>
				</div>
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