<?php
use Models\Photo;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Photo\CreateView;

/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Photo $photo
 */
?>
<h1 class="page-title">Create New Photo</h1>
<h5 class="page-title">Insert data to create an new photo</h5>
<div class="quark-presence-column left">
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form enctype="multipart/form-data" class="quark-presence-column" method="POST" id="item-form" action="/admin/photo/create">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block  middle">
                    <div class="quark-presence-column form-title">
                        Select Photo
                    </div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <img class="cm-form-photo" src="<?php echo $photo->file->WebLocation();?>">
                        <br />
                        <input type="file" class="quark-input" name="photo" onchange="setImage(this);">
                    </div>
                </div>
                <br />
                <div class="quark-presence-container presence-block">
                    <br/>
                    <button class="quark-button block ok submit-button" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>