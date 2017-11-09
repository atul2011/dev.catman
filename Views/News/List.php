<?php
/**
 * @var QuarkCollection|News[] $news
 */
use Models\News;
use Quark\QuarkCollection;
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

		$link_url = $item->link_url != '' ? $item->link_url : '/news/' . $item->id;
		$link_text = $i == 1 ?  $item->link_text : $this->CurrentLocalizationOf('Catman.News.Open');
		$img = $i == 1
			?  '<img src="/static/resources/img/news-img.png" alt=""><div class="news__description news__wrap clearfix">'
			: '<div class="news__description clearfix">';
		$news_text = $i == 1 ? substr($item->text,0,300) : $item->title;
		if ($news_text == '') $news_text = substr($item->text,0,150);

		echo
			'<div class="news">' ,
                '<div class="news__main">' ,
                    $img ,
                        '<div class="news__date">' ,
                            '<span>' ,
                                $item->publish_date ,
                            '</span>' ,
                        '</div>' ,
                        '<div class="news__content">' ,
                            '<span class="news_text">' ,
                                $news_text ,
                            '</span>' ,
                        '</div>' ,
                        '<div class="news__more">' ,
                            '<a href="' , $link_url , '">' ,
                                $link_text ,
                            '</a>' ,
                        '</div>' ,
                    '</div>' ,
                '</div>' ,
			'</div>';
		++$i;
	}
	?>
</div>