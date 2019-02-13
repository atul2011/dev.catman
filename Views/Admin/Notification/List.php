<?php
use Models\Notification;
use Quark\QuarkCollection;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkControls\ViewFragments\QuarkViewDialogFragment;
use ViewModels\Admin\Event\ListView;

/**
 * @var QuarkView|ListView $this
 * @var QuarkCollection|Notification[] $notifications
 * @var int $number
 * @var int $pages
 * @var int $page
 */
?>
<div class="quark-presence-column left" id="cm-content-container">
    <input type="hidden" id="cm-list-current-page" value="<?php echo $page;?>">
    <input type="hidden" id="cm-list-total-pages" value="<?php echo $pages;?>">
    <h1 class="page-title">Notification</h1>
    <br />
    <a class="list-item-add-button" href="/admin/notification/create/">Add</a>
    <br />
    <br />
    <div class="quark-presence-container" id="cm-list-container">
        <?php
        foreach ($notifications as $notification) {
            echo
            '<div class="quark-presence-column list-item">' ,
                '<h6 class="list-item-date">' , $notification->created, '</h6>' ,
                '<h5 class="list-item-title">' , $notification->type , ':' , $notification->target , '</h5>' ,
                '<br />' ,
                '<div class="quark-presence-container list-item-actions">' ,
                    '<a class="list-item-link action-icons cm-item-remove-dialog fa-close fa" href="/admin/notification/delete/', $notification->id , '" quark-dialog="#item-remove" cm-redirect="/admin/notification/list/" title="Delete"></a>' ,
                    '<a class="list-item-link action-icons fa-pencil fa" href="/admin/notification/'. $notification->id .'" title="Details"></a>' ,
                '</div>' ,
            '</div>';
        }
        ?>
    </div>
    <br />
    <div class="quark-presence-container cm-list-navbar"><?php echo $this->NavigationBar($pages, $page);?></div>
</div>
<?php
echo $this->Fragment(new QuarkViewDialogFragment(
	'item-remove',
	'Delete notification',
	'You are about to delete the notification. This action cannot be undone. Continue?',
	'Please wait...',
	'The notification has been deleted',
	'An error occurred. Failed to delete the notification',
	'Remove',
	'Close'
));
?>