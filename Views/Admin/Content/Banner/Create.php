<?php
/**
 * @var QuarkView|CreateView $this
 */
use Quark\QuarkView;
use ViewModels\Admin\Content\Banner\CreateView;

?>
<h1 class="page-title">Add new Banner</h1>
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
						<input type="text" placeholder="Is Active(1 or 0)" maxlength="1" class="quark-input text_field" name="active" id="item-active"/>
					</div>
				</div>
			</div>
		</div>
		<div class="quark-presence-container presence-block button-div">
			<br/>
			<button class="quark-button block ok submit-button" type="submit">
				Create
			</button>
		</div>
	</div>
</form>