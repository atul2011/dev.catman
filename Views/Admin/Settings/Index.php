<?php
use Models\Settings;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Settings\IndexView;
/**
 * @var QuarkModel|Settings $settings
 * @var QuarkView|IndexView $this
 */
?>
<div class="quark-presence-column left">
    <h1 class="page-title">Update Current Setting</h1>
    <h5 class="page-title">Insert data for update selected setting</h5>
    <br />
	<div class="quark-presence-container content-container" id="form-body">
		<form method="POST" action="/admin/settings/edit/<?php echo $settings->id;?>">
            <?php /*<div class="quark-presence-container">
                <div class="form-field title">Name</div>
                <div class="form-field input">
                    <input placeholder="Name" type="text" class="quark-input text_field" name="setting_name" value="<?php echo $settings->setting_name;?>" readonly>
                    <br /><?php echo $this->FieldError($settings, 'setting_name');?>
                </div>
            </div>
	    <br/>
	   */?>
	    <div class="quark-presence-container">
                <div class="form-field title">Description</div>
                <div class="form-field input">
                    <input placeholder="Description" type="text" class="quark-input text_field" name="setting_description" value="<?php echo $settings->setting_description;?>" readonly>
                    <br /><?php echo $this->FieldError($settings, 'setting_description');?>
                </div>
            </div>
            <br />
            <div class="quark-presence-container">
                <div class="form-field title">Value</div>
                <div class="form-field input">
                    <textarea name="setting_value" class="quark-input text_field" placeholder="Insert value for this setting"><?php echo $settings->setting_value;?></textarea>
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
