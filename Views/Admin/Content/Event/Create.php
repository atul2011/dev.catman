<?php
/**
 * @var QuarkModel|Event $event
 * @var QuarkView|CreateView $this
 * @var QuarkModel|Event $item
 */
use Models\Event;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Content\Event\CreateView;


$item = new QuarkModel(new Event());
$service = 'create';
$button_name = 'Create';
if (isset($event)) {
	$item = $event;
	$service = 'edit/' . $item->id;
	$button_name = 'Update';
}
?>
<div class="quark-presence-column left">
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" id="item-form" onsubmit="return checkTitle('name');" action="/admin/event/<?php echo $service;?>">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Name</p>
                        <input placeholder="Name" type="text" class="quark-input text_field" name="name" id="item-name" value="<?php echo $item->name; ?>">
                    </div>
                </div>
                <br />
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Release Date</p>
                        <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="startdate" id="item-release" value="<?php echo $item->startdate; ?>">
                    </div>
                </div>
                <br/>
                <div class="quark-presence-container presence-block">
                    <br/>
                    <button class="quark-button block ok submit-button" type="submit">
                        <?php echo $button_name;?>
                    </button>
                </div>
        </form>
    </div>
</div>