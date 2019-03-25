<?php
use Quark\QuarkView;
use ViewModels\Admin\Term\CreateView;
/**
 * @var QuarkView|CreateView $this
 */
?>
<div class="quark-presence-column left">
    <h1 class="page-title">Parse Glossary</h1>
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form enctype="multipart/form-data" method="POST" action="/admin/term/parse/">
            <div class="quark-presence-container presence-block middle">
                <div class="form-field title">File</div>
                <div class="form-field input">
                    <input type="file" name="file" class="quark-input text_field">
                </div>
            </div>
            <br/><br/>
            <div class="quark-presence-container presence-block">
                <button class="quark-button block ok submit-button" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>