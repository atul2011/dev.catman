<?php
/**
 * @var QuarkModel|Link $link
 * @var QuarkView|IndexView $this
 */
use Models\Link;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Link\IndexView;
?>
<h1 class="page-title">Update Current Link</h1>
<h5 class="page-title">Insert data for update selected link</h5>
<div class="quark-presence-column left">
	<div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" id="item-form" action="/admin/link/edit/<?php echo $link->id;?>">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title" value="<?php echo $link->title;?>">
                    </div>
                </div>
                <br />
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Link</p>
                        <input placeholder="Link" type="text" class="quark-input text_field" name="link" id="item-link" value="<?php echo $link->link;?>">
                    </div>
                </div>
                <br/>
                <div class="quark-presence-container presence-block">
                    <br/>
                    <button class="quark-button block ok submit-button" type="submit">Update</button>
                </div>
        </form>
	</div>
</div>