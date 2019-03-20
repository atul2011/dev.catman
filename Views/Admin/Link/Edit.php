<?php
use Models\Link;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Link\IndexView;

/**
 * @var QuarkModel|Link $link
 * @var QuarkView|IndexView $this
 */
?>
<h1 class="page-title">Update Current Link</h1>
<h5 class="page-title">Insert data for update selected link</h5>
<div class="quark-presence-column left">
	<div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" id="item-form" action="/admin/link/edit/<?php echo $link->id;?>">
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
            <br />
            <div class="quark-presence-container presence-block middle">
                <div class="title"><p>Priority</p>
                    <input type="number" min="0" max="100" class="quark-input text_field" name="priority" placeholder="Priority" value="<?php echo $link->priority;?>">
                </div>
            </div>
	        <?php
	        if (strlen($link->target_type) > 0 && strlen($link->target_value) > 0)
		        echo
		        '<br />
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Specialization</p>
                        <div class="cm-form-checkbox"><input type="checkbox" name="master" id="cm-item-master" value="' , $link->master , '">Master</div>
                    </div>
                </div>';
	        ?>
            <br/>
            <div class="quark-presence-container presence-block">
                <br/>
                <button class="quark-button block ok submit-button" type="submit">Update</button>
            </div>
        </form>
	</div>
</div>