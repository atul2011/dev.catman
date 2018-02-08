<?php
/**
 * @var QuarkView|CreateView $this
 */

use Quark\QuarkView;
use ViewModels\Admin\Link\CreateView;
?>
<h1 class="page-title">Create New Link</h1>
<h5 class="page-title">Insert data to create an new link</h5>
<div class="quark-presence-column left">
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" id="item-form" action="/admin/link/create">
            <div class="quark-presence-column" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Title</p>
                        <input placeholder="Title" type="text" class="quark-input text_field" name="title" id="item-title">
                    </div>
                </div>
                <br />
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Link</p>
                        <input placeholder="Link" type="text" class="quark-input text_field" name="link" id="item-link">
                    </div>
                </div>
                <br/>
                <div class="quark-presence-container presence-block">
                    <br/>
                    <button class="quark-button block ok submit-button" type="submit">Create</button>
                </div>
        </form>
    </div>
</div>