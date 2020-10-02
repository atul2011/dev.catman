<?php
/**
 * @var QuarkModel|Event $event
 * @var QuarkView|CreateView $this
 */
use Models\Event;
use Quark\QuarkModel;
use Quark\QuarkCollection;
use Quark\QuarkView;
use ViewModels\Admin\Event\CreateView;
?>
<h1 class="page-title">Update Current Event</h1>
<h5 class="page-title">Insert data for update selected event</h5>
<div class="quark-presence-column left">
	<div class="quark-presence-container content-container presence-block" id="form-body">
		<form method="POST" id="item-form" onsubmit="return checkTitle('name');" action="/admin/event/edit/<?php echo $event->id;?>">
			<div class="quark-presence-column" id="main_div">
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Name</p>
						<input placeholder="Name" type="text" class="quark-input text_field" name="name" id="item-name" value="<?php echo $event->name; ?>">
					</div>
				</div>
				<br />
				<div class="quark-presence-container presence-block middle">
					<div class="title"><p>Release Date</p>
						<input type="date" data-date-inline-picker="true" class="quark-input text_field" name="startdate" id="item-release" value="<?php echo $event->startdate; ?>">
					</div>
				</div>
				<br/>
				 <div class="quark-presence-container presence-block middle">
                    			<div class="quark-presence-column form-title">Notification with Articles/dictations</div>
                    			<br />
                    			<div class="quark-presence-column form-value">
                        			<textarea name="msg_with_articles" class="editor-container"><?php echo $event->msg_with_articles; ?></textarea>
                    			</div>
                		</div>
                		<br/>
                		<div class="quark-presence-container presence-block middle">
		                	<div class="quark-presence-column form-title">Notification without Articles/dictations</div>
                    			<br />
		                        <div class="quark-presence-column form-value">
                        			<textarea name="msg_without_articles" class="editor-container"><?php echo $event->msg_without_articles; ?></textarea>
                    			</div>
                		</div>
				<div class="quark-presence-container presence-block">
					<br/>
					<button class="quark-button block ok submit-button" type="submit">
						Update
					</button>
				</div>
		</form>
	</div>
</div>
