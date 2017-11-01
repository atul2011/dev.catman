<?php
use Models\Article;
use Models\Category;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Content\LayoutView;

/**
 * @var QuarkView|LayoutView $this
 */
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------top categories----------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
/**
 * @var QuarkCollection|Category[] $top_categories
 * @var QuarkModel|Category $top_category
 */
$top_category = Category::TopMenuCategory();
$top_categories = Category::TopMenuSubCategories();

$top_list = array();

foreach ($top_categories as $item) {
	$top_list[] = '<li><a href="/category/' . $item->id . '">' . $item->title . '</a></li>';
}
/**
 * @var QuarkCollection|Article[] $top_articles
 */
$top_articles = $top_category->Articles();

foreach ($top_articles as $item)
	$top_list[] = '<li><a href="/article/' . $item->id.'">'. $item->title . '</a></li>';

//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------main categories---------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
/**
 * @var QuarkModel|Category $main_category
 * @var QuarkCollection|Category[] $main_categories
 */
$main_category = Category::MainMenuCategory();
$main_categories = Category::MainMenuSubCategories();
$main_list = array();

foreach ($main_categories as $item)
	    $main_list[] = '<li><a href="/category/'.$item->id.'">'.$item->title . '</a></li>';

/**
 * @var QuarkCollection|Article[] $main_articles
 */
$main_articles = $main_category->Articles();

foreach ($main_articles as $item)
	$main_list[] = '<li><a href="/article/' . $item->id.'">'.$item->title . '</a></li>';

//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------bottom categories-------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
/**
 * @var QuarkModel|Category $bottom_category
 * @var QuarkCollection|Category[] $bottom_categories
 * @var QuarkCollection|Article[] $bottom_articles
 */
$bottom_category = Category::BottomMenuCategory();
$bottom_categories = Category::BottomMenuSubCategories();
$bottom_articles = $bottom_category->Articles(20);
$bottom_list = '';
$iterator = 1;
$bottom_items = array();

foreach ($bottom_categories as $item)
    $bottom_items[] = $item;

foreach ($bottom_articles as $item)
    $bottom_items[] = $item;

$bottom_items = array_slice($bottom_items, 0, 16);


foreach ($bottom_items as $item) {
    if ($iterator%4 == 1)
	    $bottom_list .=
        '<div class="col-sm-3 category-bottom-container">'.
            '<div class="main-site-menu category-bottom-subcontainer">'.
                '<div class="category-bottom-list">';


    $bottom_list .= $item instanceof Category
        ?
        '<div class="category-bottom-item">'.
            '<a href="/category/'.$item->id.'">'.$item->title . '</a>'.
        '</div>'
        :
        '<div class="category-bottom-item">'.
            '<a href="/article/'.$item->id.'">'.$item->title . '</a>'.
        '</div>';


	if ($iterator%4 == 0)
		$bottom_list .= '</div></div></div>';

    $iterator++;
}

//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------news--------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
$news = $this->getCurrentNews();
$news_list = array();
foreach ($news as $item){
	$link_url ='';
	$link_text= '';
    $item->link_url != '' ? $link_url = $item->link_url : $link_url = '/news/' . $item->id;
    $item->link_text != '' ? $link_text = $item->link_text :  $link_text = $this->CurrentLocalizationOf('Catman.News.Open');

	$news_item ='<div class="news">'.
		'<div class="news__main">'.
            '<div class="news__description news__wrap clearfix">'.
                '<div class="news__date">'.
                    '<span>'.
                        $item->publish_date.
                    '</span>'.
                '</div>'.
                '<div class="news__content">'.
                    '<span>'.
                        substr(trim($item->text,' '),0,160).
                    '</span>'.
                '</div>'.
                '<div class="news__more">'.
                    '<a href="'.$link_url.'">'.
                        $link_text.
                    '</a>'.
                '</div>'.
                '</div>'.
            '</div>'.
		'</div>';
	$news_list[] = $news_item;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta property="og:image" content="path/to/image.jpg">
    <meta name="theme-color" content="#000">
    <meta name="msapplication-navbutton-color" content="#000">
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">

	<link rel="shortcut icon" href="/static/Content/resources/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="/static/Content/resources/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/static/Content/resources/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/static/Content/resources/img/favicon/apple-touch-icon-114x114.png">
	<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700|Open+Sans:300,400,600,600i,700" rel="stylesheet">
    <?php echo $this->Resources();?>
    <title id="page-title"></title>
</head>

<body>


<header>

	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9" id="nav-bar-menu">
				<ul class="top_mnu" id="nav-bar-menu-list">
					<li><a href="/" class="home"><img src="/static/Content/resources/img/home.png" alt=""></a></li>
					<?php foreach ($top_list as $item) echo $item;?>
				</ul>
			</div>

			<div class="col-lg-3 col-md-3" id="nav-bar-search">
				<div class="span12">
					<form action="http://www.google.ru/search" id="custom-search-form" class="form-search form-horizontal">
						<div class="input-append span12" id="nav-bar-search-container">
                            <input type="hidden" name="as_sitesearch" value="universalpath.org">
                            <input type="text" class="search-query" name="as_q" placeholder="Ищите и найдете!">
                            <button type="submit" class="btn"></button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<a href="#" class="slide-menu-open"></a>
				<div class="side-menu-overlay"></div>
				<div class="side-menu-wrapper" id="mobile-category-top-container">
					<a href="#" class="menu-close" id="mobile-category-top-list">&times;</a>
					<ul><?php foreach ($top_list as $item) echo $item;?></ul>
				</div>
			</div>
		</div>
	</div>

</header>
<section class="main-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Универсальный Путь</h1>
			</div>
		</div>
		<div class="block-center">
			<div class="row">
				<div class="col-md-12 padding-none">

					<div class="content_mnu">
						<div class="container">
							<div class="row">
								<div class="col-md-12" id="category-top-container">
									<ul class="inner_mnu" id="category-top-list">
										<?php
										$mini_main_list = array_slice($main_list, 0, 3);

										foreach ($mini_main_list as $item) echo $item;
										?>
										<li class="dropdown-item" id="category-top-list-dropdown">
											<div class="dropdown">
												<div class="dropdown-content">
													<ul>
														<?php
														$rest_main_list = array_slice($main_list, 3);
														foreach ($rest_main_list as $item) echo $item;
														?>
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row margin-none">
				<div class="col-md-9 padding-none" id="content-container">
                    <?php echo $this->View();?>
				</div>
				<div class="col-md-3 padding-none">
					<div class="block-center__right js-equal-height">
                        <div id="related-websites-container">
                            <h3 class="main-headline">РОДСТВЕННЫЕ САЙТЫ</h3>
                            <a href="#" class="related-websites bg-yellow">
                                <h4>ASK REAL JESUS</h4>
                                <span href="#">askrealjesus.com</span>
                            </a>
                            <a href="#" class="related-websites bg-red">
                                <h4>ASK REAL JESUS</h4>
                                <span href="#">askrealjesus.com</span>
                            </a>
                            <a href="#" class="related-websites bg-blue">
                                <h4>ASK REAL JESUS</h4>
                                <span href="#">askrealjesus.com</span>
                            </a>
                        </div>
						<div class="news-right" id="news-container">
                            <?php foreach ($news_list as $item) echo $item;?>
							<div class="all-news">
								<a href="/news/list" class="all-news__link">ВСЕ НОВОСТИ</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section  class="section-menu">
	<div class="container">
		<div class="row">
			<div class="section-menu-wrapper">
				<div class="col-sm-12">
					<h3 class="main-headline">ОСНОВНЫЕ РАЗДЕЛЫ САЙТА</h3>
				</div>
                <div id="category-bottom-container">
                    <?php echo $bottom_list;?>
                </div>
            </div>
		</div>
	</div>
</section>
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="footer__bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h4>Все права защищены © 2002-2016 Ким Майклс</h4>
							<p>Публикация материалов с этого сайта разрешается только при указании ссылки на страницу-оригинал и информации об авторских правах</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
</body>
</html>