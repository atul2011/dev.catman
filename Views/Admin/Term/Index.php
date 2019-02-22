<?php
use Models\Term;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Term\IndexView;
/**
 * @var QuarkModel|Term $term
 * @var QuarkView|IndexView $this
 */
?>
<div class="quark-presence-column left">
    <h1 class="page-title">Update Current Term</h1>
    <h5 class="page-title">Insert data for update selected term</h5>
    <br />
	<div class="quark-presence-container content-container" id="form-body">
		<form method="POST" action="/admin/term/edit/<?php echo $term->id;?>">
            <div class="quark-presence-container">
                <div class="form-field title">Title</div>
                <div class="form-field input">
                    <input placeholder="Title" type="text" class="quark-input text_field" name="title" value="<?php echo $term->title;?>">
                    <br /><?php echo $this->FieldError($term, 'title');?>
                </div>
            </div>
            <br />
            <div class="quark-presence-container">
                <div class="form-field title">Description</div>
                <div class="form-field input">
                    <textarea name="description" class="quark-input text_field" placeholder="Insert description for this term"><?php echo $term->description;?></textarea>
                </div>
            </div>
            <br/>
            <div class="quark-presence-container">
                <div class="form-field title">
                    <button class="quark-button block ok submit-button" type="submit">Save</button>
                </div>
            </div>
		</form>
	</div>
</div>