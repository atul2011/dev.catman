<?php
/**
 * @var QuarkModel|Photo $photo
 * @var QuarkView|CreateView $this
 */

use Models\Photo;
use Models\Photo_has_Tag;
use Models\Tag;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Event\CreateView;
?>
<h1 class="page-title">Update Current Event</h1>
<h5 class="page-title">Insert data for update selected event</h5>
<div class="quark-presence-column left">
	<div class="quark-presence-container content-container presence-block" id="form-body">
        <form enctype="multipart/form-data" method="POST" id="item-form" action="/admin/photo/edit/<?php echo $photo->id;?>">
            <input type="hidden" id="cm-photo-id" value="<?php echo $photo->id;?>">
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
                        $tags = $photo->Tags();

                        foreach ($tags as $tag) {
	                        /**
	                         * @var QuarkModel|Tag $tag
	                         */
                            echo
                                '<button type="button" class="quark-button block cm-button-tag cm-button-sub-item-action" action="/admin/photo/tag/unlink/' , Photo_has_Tag::GetLink($photo, $tag)->id ,'">' ,
                                    $tag->name ,'  ',
                                    '<a class="fa fa-close"></a>',
                                '</button>';
                        }
                        ?>
                    </div>
                </div>
                <br />
                <div class="quark-presence-container presence-block">
                    <br/>
                    <button class="quark-button block ok submit-button" type="submit">Update</button>
                </div>
            </div>
        </form>
	</div>
</div>