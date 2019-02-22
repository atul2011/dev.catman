<?php
use Models\Term;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Term\CreateView;
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Term $term
 */
?>
<div class="quark-presence-column left">
    <h1 class="page-title">Create New Term</h1>
    <h5 class="page-title">Insert data to create an new term</h5>
    <br />
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" action="/admin/term/create">
            <div class="quark-presence-container presence-block middle">
                <div class="form-field title">Title</div>
                <div class="form-field input">
                    <input placeholder="Title" type="text" class="quark-input text_field" name="title" value="<?php echo $term->title;?>">
                    <br /><?php echo $this->FieldError($term, 'title');?>
                </div>
            </div>
            <br />
            <div class="quark-presence-container presence-block middle">
                <div class="form-field title">Description</div>
                <div class="form-field input">
                    <textarea name="description" class="quark-input text_field" placeholder="Insert description for this term"><?php echo $term->description;?></textarea>
                </div>
            </div>
            <br/>
            <div class="quark-presence-container presence-block">
                <button class="quark-button block ok submit-button" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>