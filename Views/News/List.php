<?php
/**
 * @var QuarkCollection|News[] $news
 * @var QuarkView|ListView $this
 */
use Models\News;
use Quark\QuarkCollection;
use Quark\QuarkView;
use ViewModels\News\ListView;

?>
<div class="block-center__left js-equal-height">
	<h3 class="main-headline">НОВОСТИ УНИВЕРСАЛЬНОГО ПУТИ</h3>
	<?php
	$all_news = array();
	$i = 1;

	foreach ($news as $item){
		$link_url ='';
		$link_text= '';
		$news_text = '';
		$img = '';

		$link_url = strlen(trim($item->link_url)) > 0 ? $item->link_url : '/news/' . $item->id;
		$link_text = strlen(trim($item->link_text)) > 0 ?  $item->link_text : $this->CurrentLocalizationOf('Catman.News.Open');

		$img = $i == 1
			?  '<img src="/static/resources/img/news-img.png" alt=""><div class="news__description news__wrap clearfix">'
			: '<div class="news__description clearfix">';

		$news_text = $item->title;
		if ($news_text == '') $news_text = $item->text;

        $openInOverlay = strlen(trim($item->link_url)) == 0
            ? 'class="openInOverlay" news-title="' . $item->title . '" news-description="' . htmlspecialchars($item->text) . '"'
            : 'href="' . $link_url . '"';

		echo '<div class="news">' ,
                '<div class="news__main">' ,
                    $img ,
                        '<div class="news__date">' ,
                            '<span>' , $item->publish_date->Format('d/m/Y') , '</span>' ,
                        '</div>' ,
                        '<div class="news__content">' ,
                            '<span class="news_text">' , $news_text , '</span>' ,
                        '</div>' ,
                        '<div class="news__more">' ,
                            '<a ', $openInOverlay ,'>' , $link_text , '</a>' ,
                        '</div>' ,
                    '</div>' ,
                '</div>' ,
			'</div>';
		++$i;
	}
	?>
</div>
<div id="news-overlay">
    <div class="news-overlay-content">
        <div class="news-title-container">
            <div class="news-title"></div>
            <img src="/static/resources/img/icon_close.png" class="news-icon overlay-close">
        </div>
        <div class="news-description"></div>
    </div>
</div>