<?php
/**
 * @var QuarkView|ListView $this
 * @var QuarkCollection|Link[] $links
 */
use Models\Link;
use Quark\QuarkCollection;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Event\ListView;
?>
<h1 class="page-title">Link List</h1>
<h5 class="page-title">Navigate through links</h5>
<div class="quark-presence-column left" id="content-container">
    <div class="quark-presence-container presence-block main2 items-list" id="event-list">
        <div class="quark-presence-column" id="content-column">
            <div class="quark-presence-container presence-block" id="list-content">
                <div id="ID" class="quark-presence-column content-titles ids">ID</div>
                <div id="title" class="quark-presence-column  content-titles titles">Title</div>
                <div id="link" class="quark-presence-column  content-titles links">Link</div>
                <div id="actions" class="quark-presence-column  content-titles actions">Actions</div>
            </div>
            <?php
            foreach ($links as $link) {
                echo
                '<div class="quark-presence-container presence-block content-row" id="event-values-' , $link->id , '">' ,
                    '<div class="content-values quark-presence-column ids">' , $link->id , '</div>' ,
                    '<div class="content-values quark-presence-column titles">' , $link->title  , '</div>' ,
                    '<div class="content-values quark-presence-column links">' , $link->link , '</div>' ,
                    '<div class="content-values quark-presence-column actions">' ,
                        '<a class="fa actions edit-button-link fa-pencil content-actions " id="edit-link-' , $link->id , '" href="/admin/link/edit/' , $link->id , '"></a>' ,
                        '<a class="fa actions delete-button-link fa-trash content-actions item-remove-dialog" quark-dialog="#item-remove" quark-redirect="/admin/link/list/" id="delete-link-' , $link->id , '" href="/admin/link/delete/' , $link->id , '"></a>' ,
                    '</div>' ,
                '</div>';
            }
            ?>
        </div>
    </div>
    <br/>
    <div class="quark-presence-container presence-block" id="list-options">
        <div class="quark-presence-column right">
            <div class="quark-presence-container button-div" id="form-add-button">
                <div class="quark-presence-column right button-add-column" id="button-add-column">
                    <form action="/admin/link/create" method="GET">
                        <button type="submit" class=" button-add">+</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Fragment(new QuarkViewDialogFragment(
	'item-remove',
	'Delete link.',
	'You are about to delete the link. This action cannot be undone. Continue?',
	'Please wait...',
	'The link was deleted',
	'An error occurred. Failed to delete the link',
	'Remove',
	'Close'
));
?>