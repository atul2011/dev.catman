<?php
use Models\Settings;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Settings\CreateView;
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Term $term
 */
?>
<div class="quark-presence-column left">
    <h1 class="page-title">Create New Setting</h1>
    <h5 class="page-title">Insert data to create an new setting</h5>
    <br />
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" action="/admin/settings/create">
            <div class="quark-presence-container presence-block middle">
                <div class="form-field title">Name</div>
                <div class="form-field input">
                    <input placeholder="Name" type="text" class="quark-input text_field" name="setting_name" value="<?php echo $settings->setting_name;?>">
                    <br /><?php echo $this->FieldError($settings, 'setting_name');?>
                </div>
            </div>
            <br />
	    <div class="quark-presence-container presence-block middle">
                <div class="form-field title">Description</div>
                <div class="form-field input">
                    <input placeholder="Description" type="text" class="quark-input text_field" name="setting_description" value="<?php echo $settings->setting_description;?>">
                    <br /><?php echo $this->FieldError($settings, 'setting_description');?>
                </div>
            </div>
	    <br/>
            <div class="quark-presence-container presence-block middle">
                <div class="form-field title">Value</div>
                <div class="form-field input">
                    <textarea name="setting_value" class="quark-input text_field" placeholder="Insert value for this setting name"><?php echo $settings->setting_value;?></textarea>
                </div>
            </div>
            <br/>
            <div class="quark-presence-container presence-block">
                <button class="quark-button block ok submit-button" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
