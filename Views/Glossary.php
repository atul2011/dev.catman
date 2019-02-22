<?php
use Models\Term;
use Quark\QuarkCollection;
use Quark\QuarkView;
use ViewModels\GlossaryView;

/**
 * @var QuarkView|GlossaryView $this
 * @var QuarkCollection|Term[] $terms
 * @var array $letters
 * @var array $listed_letters
 */
$items = array();
$final_items = array();
error_reporting(0);
foreach ($terms as $key => $term) {
    $items[$term->first_letter][] =
            '<a class="glossary-item-title related-item-link" glossary-description="' . $term->description . '" glossary-title="' . $term->title . '">' . $term->title . '</a>';
}
error_reporting(-1);
?>
<div class="block-center__left js-equal-height">
    <div id="glossary-overlay">
        <div class="glossary-overlay-content">
            <div class="glossary-title-container">
                <div class="glossary-title"></div>
                <img src="/static/resources/img/icon_close.png" class="glossary-icon overlay-close">
            </div>
            <div class="glossary-description"></div>
        </div>
    </div>
    <div class="item-head">
        <a class="page-title" href="/glossary"><h3 class="main-headline item-main-headline" id="content-title">Глоссарий</h3></a>
    </div>
    <hr class="cm-delimiter cm-header-content-delimiter">
    <div class="item-content">
        <div class="item-content-container">
            <div class="item-related-content">
				<?php
                foreach ($letters as $key => $letter) {
                    echo  '<a href="/glossary/' . $letter . '" class="related-item-link glossary-link">' . $letter . '</a>';

                    if (in_array($letter, $listed_letters)) {
                        $final_items[] = '<div class="glossary-column-header">' . $letter .'</div>';

	                    foreach ($items[$letter] as $item)
		                    $final_items[] = $item;
                    }
                }
                ?>
                <br />
                <hr>
                <?php
                $size = sizeof($final_items);
                $column_number = sizeof($listed_letters) >=3 ? 3 : sizeof($listed_letters);
                $column_size = $size % $column_number == 0 ? ((int)($size / $column_number)) : (((int)($size / $column_number)) + 1);
                $columns = array_chunk($final_items, $column_size);

                foreach ($columns as $key => $column_items) {
	                echo '<div class="glossary-column">';
	                foreach ($column_items as $item) {
	                    echo $item;
                    }
	                echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>