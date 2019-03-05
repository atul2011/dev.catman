<?php
use Models\Article;
use Models\Category;
use Models\Link;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Link\CreateView;

/**
 * @var QuarkView|CreateView $this
 * @var string $target_type
 * @var string $target_value
 */
$parent_name = '';
if ($target_type == Link::TARGET_TYPE_CATEGORY) {
    /**
     * @var QuarkModel|Category $category
     */
    $category = QuarkModel::FindOneById(new Category(), $target_value);

    if ($category != null) {
        $parent_name = 'of category "' . $category->title . '"';
    }
}
elseif ($target_type == Link::TARGET_TYPE_ARTICLE) {
    /**
     * @var QuarkModel|Article $article
     */
    $article = QuarkModel::FindOneById(new Article(), $target_value);

    if ($article != null) {
        $parent_name = 'of article "' . $article->title . '"';
    }
}
?>
<h1 class="page-title">Create New Link <?php echo $parent_name;?></h1>
<h5 class="page-title">Insert data to create an new link</h5>
<div class="quark-presence-column left">
    <div class="quark-presence-container content-container presence-block" id="form-body">
        <form method="POST" id="item-form" action="/admin/link/create">
            <input type="hidden" name="target_type" value="<?php echo $target_type;?>">
            <input type="hidden" name="target_value" value="<?php echo $target_value;?>">
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
            <?php
            if (strlen($parent_name) > 0 )
                echo
                '<br />
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Specialization</p>
                        <div class="cm-form-checkbox"><input type="checkbox" name="master" id="cm-item-master">Master</div>
                    </div>
                </div>';
            ?>
            <br/>
            <div class="quark-presence-container presence-block">
                <br/>
                <button class="quark-button block ok submit-button" type="submit">Create</button>
            </div>
        </form>
    </div>
</div>