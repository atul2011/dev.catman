<?php
/**
 * @var QuarkModel|News $news
 */
use Models\News;
use Quark\QuarkModel;
$all_news = array();
$i = 1;
foreach ($news as $item){
	$link_url ='';
	$link_text= '';
	$news_text = '';
	$img = '';

	$item->link_url != '' ? $link_url = $item->link_url : $link_url = '/news/' . $item->id;
	$i == 1 ? $link_text = $item->link_text :  $link_text = $this->CurrentLocalizationOf('Catman.News.Open');
	$i == 1 ? $img = '<img src="/static/Content/resources/img/news-img.png" alt=""><div class="news__description news__wrap clearfix">'
			: $img = '<div class="news__description clearfix">';
	$i == 1 ? $news_text = substr($item->text,0,300) : $news_text = $item->title;
	if ($news_text == '') $news_text = substr($item->text,0,150);

	 $string =
		 '<div class="news">' .
			 '<div class="news__main">' .
				 $img .
					 '<div class="news__date">' .
						 '<span>' .
							 $item->publish_date .
						 '</span>' .
					 '</div>' .
					 '<div class="news__content">' .
						 '<span class="news_text">' .
							 $news_text .
						 '</span>' .
					 '</div>' .
					 '<div class="news__more">' .
						 '<a href="' . $link_url . '">' .
							 $link_text .
						 '</a>' .
					 '</div>' .
				 '</div>' .
			 '</div>' .
		 '</div>';
		++$i;
		$all_news[] = $string;
}
?>
<div class="block-center__left js-equal-height">
	<h3 class="main-headline">НОВОСТИ УНИВЕРСАЛЬНОГО ПУТИ</h3>
	<?php foreach ($all_news as $item) echo  $item;?>
</div>