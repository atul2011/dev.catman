<?php
/**
 * @var QuarkView|CreateView $this
 */

use Quark\QuarkCollection;
use Quark\QuarkView;
use ViewModels\Admin\Event\CreateView;
?>
<h1 class="page-title">Create New Event</h1>
<h5 class="page-title">Insert data to create an new event</h5>
<div class="quark-presence-column left">
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" id="item-form" onsubmit="return checkTitle('name');" action="/admin/event/create">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Name</p>
                        <input placeholder="Name" type="text" class="quark-input text_field" name="name" id="item-name">
                    </div>
                </div>
                <br />
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Release Date</p>
                        <input type="date" data-date-inline-picker="true" class="quark-input text_field" name="startdate" id="item-release">
                    </div>
                </div>
                <br/>
		<div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-column form-title">Notification with Articles/dictations</div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <textarea name="msg_with_articles" class="editor-container"></textarea>
                    </div>
                </div>
		<br/>
                <div class="quark-presence-container presence-block middle">
                    <div class="quark-presence-column form-title">Notification without Articles/dictations</div>
                    <br />
                    <div class="quark-presence-column form-value">
                        <textarea name="msg_without_articles" class="editor-container"></textarea>
                    </div>
                </div>
                <div class="quark-presence-container presence-block">
                    <br/>
                    <button class="quark-button block ok submit-button" type="submit">
                        Create
                    </button>
                </div>
        </form>
    </div>
</div>
