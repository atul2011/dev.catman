<?php
/**
 * @var QuarkView|ListView $this
 * @var int $number
 */

use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Token\ListView;

echo $this->Fragment(new QuarkViewDialogFragment(
    'item-remove',
    'Delete token',
    'You are about to delete the token. This action cannot be undone. Continue?',
    'Please wait...',
    'The token was deleted',
    'An error occurred. Failed to delete the token',
    'Remove',
    'Close'
));
?>
<h1 class="page-title">Token List</h1>
<h5 class="page-title">Navigate through tokens</h5>
<div class="quark-presence-column left" id="content-container">
    <div class="quark-presence-container presence-block middle items-list" id="token-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="name" class="quark-presence-column  content-titles tokens">Token</div>
                <div id="type" class="quark-presence-column  content-titles creates">Create Date</div>
                <div id="actions" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
            <div class="loader" id="loading-circle"></div>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <form action="/admin/token/create" method="GET">
                        <button type="submit" class="button-add">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>