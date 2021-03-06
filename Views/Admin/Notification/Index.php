<?php
/**
 * @var QuarkView|IndexView $this
 * @var QuarkModel|Notification $notification
 */
use Models\Notification;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Notification\IndexView;
?>
<h1 class="page-title">Update notification</h1>
<h5 class="page-title">Here you can see and edit notification details</h5>
<form class="quark-presence-column left" method="POST" id="form" action="/admin/notification/update/<?php echo $notification->id;?>">
    <br />
    <div class="quark-presence-container cm-form-field">
        <h5>Content</h5>
        <textarea name="content" class="quark-input cm-form-input cm-form-textarea"><?php echo $notification->content;?></textarea>
    </div>
    <div class="quark-presence-container cm-form-field">
        <h5>Item Type</h5>
        <select class="quark-input cm-form-input" name="type">
            <option disabled selected>Select Notification Type</option>
            <option value="<?php echo Notification::PAYLOAD_TYPE_CATEGORY;?>">Category</option>
            <option value="<?php echo Notification::PAYLOAD_TYPE_ARTICLE;?>">Article</option>
        </select>
    </div>
    <br />
    <div class="quark-presence-container cm-form-field">
        <h5>Item Id</h5>
        <input type="number" class="quark-input cm-form-input" name="target" value="<?php echo $notification->target;?>">
    </div>
    <div class="quark-presence-container cm-form-field">
        <button type="submit" class="quark-button block ok">Update</button>
    </div>
</form>