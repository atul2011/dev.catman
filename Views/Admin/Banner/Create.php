<?php
use Quark\QuarkView;
use ViewModels\Admin\Content\Banner\CreateView;

/**
 * @var QuarkView|CreateView $this
 */
?>
<h2 class="page-title">Add New Banner</h2>
<h5>Insert data to create an new banner</h5>
<form enctype="multipart/form-data" method="POST" id="item-form"  action="/admin/banner/create">
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
						<select class="quark-input text_field" name="active" id="item-active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
					</div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block button-div">
			<br/>
			<button class="quark-button block ok submit-button" type="submit">Create</button>
		</div>
	</div>
</form>