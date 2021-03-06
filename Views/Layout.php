<?php
use Models\Article;
use Models\Banner;
use Models\Category;
use Models\Link;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\LayoutView;

/**
 * @var QuarkView|LayoutView $this
 * @var QuarkCollection|Banner[] $random_banner
 * @var QuarkModel|Banner $banner
 */
$random_banner = QuarkModel::FindRandom(new Banner());
$banner = $random_banner[0];
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

foreach ($top_categories as $index => $item) {
	if ($item->available_on_site !== true) continue;

	$top_list[] = '<a class="up-item-link" href="/category/' . $item->id . '">' . $item->short_title . '</a>';
	if ($index == 1) $top_list[] = '<a class="up-item-link" href="https://www.km-book.com/shop">Книги</a>';//add link after 1 element
}
/**
 * @var QuarkCollection|Article[] $top_articles
 */
$top_articles = $top_category->Articles();

foreach ($top_articles as $item) {
	$top_list[] = '<a class="up-item-link" href="/article/' . $item->id . '">' . $item->short_title . '</a>';
}

$top_list[] = '<a class="up-item-link" href="/user/contact">Написать нам</a>';

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

foreach ($main_categories as $item) {
	if ($item->available_on_site !== true)	continue;

    $main_list[] = '<a class="up-item-link" href="/category/' . $item->id . '">' . $item->short_title . '</a>';
}
/**
 * @var QuarkCollection|Article[] $main_articles
 */
$main_articles = $main_category->Articles();

foreach ($main_articles as $item)
	$main_list[] = '<a class="up-item-link" href="/article/' . $item->id.'">'.$item->short_title . '</a>';

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
$bottom_articles = $bottom_category->Articles(array(
    QuarkModel::OPTION_LIMIT => 20,
    QuarkModel::OPTION_SORT => array('runtime_priority' => QuarkModel::SORT_ASC)
));

$bottom_list = '';
$iterator = 1;
$bottom_items = array();

foreach ($bottom_categories as $item) {
	if ($item->available_on_site !== true)	continue;

	$bottom_items[] = $item;
}
foreach ($bottom_articles as $item)
    $bottom_items[] = $item;

$bottom_items = array_slice($bottom_items, 0, 16);


foreach ($bottom_items as $item) {
	/**
	 * @var QuarkModel $item
	 */

    if ($iterator%4 == 1)
	    $bottom_list .=
        '<div class="col-sm-3 category-bottom-container">'.
            '<div class="main-site-menu category-bottom-subcontainer">'.
                '<div class="category-bottom-list">';

    $bottom_list .= $item->Model() instanceof Category
        ?
        '<div class="category-bottom-item">'.
            '<a class="up-item-link" href="/category/'.$item->id.'">'.$item->short_title . '</a>'.
        '</div>'
        :
        '<div class="category-bottom-item">'.
            '<a class="up-item-link" href="/article/'.$item->id.'">'.$item->short_title . '</a>'.
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
                        $item->publish_date->Format('d/m/Y').
                    '</span>'.
                '</div>'.
                '<div class="news__content">'.
                    '<span>'.
                        trim($item->text).
                    '</span>'.
                '</div>'.
//                '<div class="news__more">'.
//                    '<a href="'.$link_url.'">'.
//                        $link_text.
//                    '</a>'.
//                '</div>'.
                '</div>'.
            '</div>'.
		'</div>';
	$news_list[] = $news_item;
}

//--------------------------------------------------------------------------------------------------------
//////////////////////Master Category Links

/**
 * @var QuarkModel|Category $category
 * @var QuarkModel|Article $article
 * @var QuarkCollection|Link[] $links
 * @var string $user
 */
$master_links = array();
$user = isset($user) ? $user : '';

if (isset($article)) {
	/**
	 * @var QuarkCollection|Category[] $master_categories
	 * @var QuarkCollection|Article[] $master_articles
	 */
	$master_categories = $article->GetMasterCategoryChildes($user);
	$master_articles = $article->MasterArticles();

	foreach ($master_articles as $item) {
	    if ((string)$item->id == (string)$article->id) continue;

		$master_links[] = '<a class="up-item-link link-article-article" href="/article/' . $item->id . '">' . $item->short_title . '</a>';
	}

	foreach ($master_categories as $item)
		$master_links[] = '<a class="up-item-link link-article-category" href="/category/' . $item->id . '">' . $item->short_title . '</a>';
}

if (isset($category)) {
    //Set master articles
	/**
	 * @var QuarkCollection|Article[] $category_articles
	 */
	$category_articles = $category->MasterArticles();

	foreach ($category_articles as $item) {
		$master_links[] = '<a class="up-item-link link-category-article" href="/article/' . $item->id . '">' . $item->short_title . '</a>';
    }

    if ($category->sub == Category::TYPE_ARCHIVE) {
	    if (isset($sort_fields)) {
		    foreach ($sort_fields as $key => $value)
			    $master_links[] = '<a class="up-item-link link-archive" href="/category/' . $category->id . '/sort/' . $key  . '">' . $this->CurrentLocalizationOf($value) . '</a>';
	    }
    }

    //set master childes
    /**
     * @var QuarkCollection|Category[] $master_categories
     */
    $master_categories = $category->GetMasterCategoryChildes($user);

    foreach ($master_categories as $item) {
        if ((string)$item->id == (string)$category->id) continue;

        $master_links[] = '<a class="up-item-link link-category-category" href="/category/' . $item->id . '">' . $item->short_title . '</a>';
    }
}

if (isset($links)) {
	foreach ($links as $link) {
	    if ($link->master == true)
		    $master_links[] = '<a class="up-item-link link-link" href="' . $link->link . '">' . $link->title . '</a>';
	}
}

//9-----------------------------------------------New Category-----------------------------------
/**
 * @var QuarkCollection|Category $new_category
 */
$new_category = Category::NewCategory();
$new_category_link = '<li><a class="up-item-link" href="/category/' . $new_category->id . '">' . $new_category->title . '</a></li>';

//Set Title
$title = 'Универсальный Путь';
if (isset($category))  $title = $category->title;
if (isset($article)) $title = $article->title;

//Set Description
$description = "Сайт посвящён учениям Вознесённых Владык новой диспенсации.";
if (isset($category)) $description = implode('. ', array_slice(explode('.', $category->intro), 0, 1)) . '.';
if (isset($article)) $description = implode('. ', array_slice(explode('.', $article->txtfield), 0, 1)) . '.';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title ><?php echo $title;?></title>
    <!-- Search Engine -->
    <meta name="description" content="<?php echo strip_tags($description);?>">
    <meta name="image" content="http://universalpath.org/static/resources/img/favicon/favicon.ico">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="Универсальный Путь">
    <meta itemprop="description" content="Сайт посвящён учениям Вознесённых Владык новой диспенсации.">
    <meta itemprop="image" content="http://universalpath.org/static/resources/img/favicon/favicon.ico">
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta name="og:title" content="<?php echo $title;?>">
    <meta name="og:site_name" content="<?php echo $title;?>">
    <meta name="og:image" content="http://universalpath.org/static/resources/img/favicon/favicon.ico">
    <meta name="og:description" content="<?php echo strip_tags($description);?>">
    <meta name="og:type" content="website">
	<meta name="og:url" content="http://universalpath.org/">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta property="og:image" content="http://universalpath.org/static/resources/img/favicon/favicon.ico">
    <meta name="theme-color" content="#000">
    <meta name="msapplication-navbutton-color" content="#000">
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">

	<link rel="shortcut icon" href="/static/resources/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="/static/resources/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/static/resources/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/static/resources/img/favicon/apple-touch-icon-114x114.png">
	<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700|Open+Sans:300,400,600,600i,700" rel="stylesheet">
    <?php echo $this->Resources();?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<header>
	<div class="container" id="top-bar">
		<div class="row top-bar-list-container">
			<div class="col-lg-9 col-md-9" id="nav-bar-menu">
				<ul class="top_mnu" id="nav-bar-menu-list">
					<li><a href="/" class="home"><img src="/static/resources/img/home.png" alt=""></a></li>
					<?php
					foreach ($top_list as $item) echo '<li>' , $item , '</li>';
                    ?>
				</ul>
			</div>
			<div class="col-lg-3 col-md-3" id="nav-bar-search">
				<div class="span12">
					<form action="http://www.google.ru/search" id="custom-search-form" class="form-search form-horizontal">
						<div class="input-append span12" id="nav-bar-search-container">
                            <input type="hidden" name="as_sitesearch" value="www.universalpath.org">
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
					<ul class="side-menu-list">
                    <li><a href="/" class="home"><img src="/static/resources/img/home.png" alt=""></a></li>
					<?php
					foreach ($top_list as $item) echo '<li>' , $item , '</li>';

                    echo '<li class="list-delimiter"><hr></li>';

					foreach ($main_list as $item) echo '<li>' , $item , '</li>';
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>
<section class="main-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <h1 class="site-logo-title"><a href="/" class="site-logo-link">Универсальный Путь </a></h1>
			</div>
		</div>
		<div class="block-center">
			<div class="row">
				<div class="col-md-12 padding-none">
					<div class="content_mnu">
						<div class="container container-full">
							<div class="row">
								<div class="col-md-12" id="category-main-container">
									<ul class="inner_mnu" id="category-main-list">
										<?php
//										$mini_main_list = array_slice($main_list, 0, 5);

										foreach ($main_list as $item)
										    echo '<li>' , $item , '</li>';
										?>
<!--										<li class="dropdown-item" id="category-main-list-dropdown">-->
<!--											<div class="dropdown"></div>-->
<!--										</li>-->
<!--                                        --><?php //echo $new_category_link;?>
<!--                                        <span class="inner_mnu-expanded">-->
										<?php
//										$rest_main_list = array_slice($main_list, 5);
//										foreach ($rest_main_list as $item)
//											echo '<li>' , $item , '</li>';
										?>
<!--                                        </span>-->
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row margin-none">
                <div class="col-md-2 padding-none" id="main-links-container">
                    <div class="block-center__right js-equal-height related-items-container">
                        <div class="up-links-container">
                            <?php
                            foreach ($master_links as $item)
                                echo $item;
                            ?>
                            <?php

                            if (isset($article) && $article->id == 1)
                                foreach ($top_list as $item) echo $item ;
                            ?>
                        </div>
                    </div>
                </div>
				<div class="col-md-7 padding-none" id="content-container">
                    <?php echo $this->View();?>
				</div>
				<div class="col-md-3 padding-none" id="additional-links-container">
					<div class="block-center__right js-equal-height related-items-container">
                        <div class="related-internal-links special">
                            <iframe id="support-form-frame" src="https://money.yandex.ru/quickpay/shop-widget?writer=seller&targets=%D0%9F%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%B0%D1%82%D1%8C%20%D1%81%D0%B0%D0%B9%D1%82&targets-hint=&default-sum=&button-text=11&payment-type-choice=on&mobile-payment-type-choice=on&fio=on&mail=on&hint=&successURL=&quickpay=shop&account=4100115521007930" width="100%" height="250" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
                        </div>
                        <div class="related-internal-links special">
                            <a href="/article/2707" class="related-websites heavy bg-red">
                                <h4>МЫСЛЕФОРМА НА ГОД</h4>
                            </a>
                        </div>
                        <div class="related-internal-links special" style="margin-top: 20px;">
                            <a href="/glossary" class="related-websites heavy bg-yellow">
                                <h4>ГЛОССАРИЙ</h4>
                            </a>
                        </div>
						<div class="news-right" id="news-container" style="margin-top: 20px;">
                            <h3 class="main-headline">НОВОСТИ</h3>
                            <?php
                            foreach ($news_list as $item)
                                echo $item;
                            ?>
							<div class="all-news">
								<a href="/news/list" class="all-news__link">ВСЕ НОВОСТИ</a>
							</div>
						</div>
                        <div id="related-websites-container" style="margin-top: 20px;">
                            <h3 class="main-headline">ССЫЛКИ НА САЙТЫ</h3>
							<?php
							/**
							 * @var QuarkCollection|Link[] $external_links
							 */
							$external_links = Link::IndependentLinks();

							foreach ($external_links as $key => $link) {
								/**
								 * @var QuarkModel|Link $link
								 */
								echo
								'<a href="' , trim($link->link) ,'" class="related-websites ' , $this->GetColor($key) ,'">' ,
                                    '<h4>' , trim($link->title) ,'</h4>' ,
//                                    '<span>' , $link->link , '</span>' ,
								'</a>';
							}
							?>
                        </div>
                        <div class="related-internal-links" style="margin-top: 20px;">
                            <h3 class="main-headline">БДЕНИЯ СООБЩЕСТВА</h3>
                            <a href="https://worldsundayvigil.net/" class="related-websites bg-red" target="_blank" >
                                <h4>Воскресные Бдения</h4>
                            </a>
                            <a href="https://www.facebook.com/groups/406028906779353" class="related-websites bg-blue" target="_blank" >
                                <h4>Призывы для России</h4>
                            </a>
                            <a href="https://www.facebook.com/groups/2387621914823702" class="related-websites bg-yellow" target="_blank" >
                                <h4>Бдения для Украины</h4>
                            </a>
                        </div>
                        <div class="related-internal-links" style="margin-top: 20px;">
                            <h3 class="main-headline">НАШИ СТРАНИЦЫ В СОЦСЕТЯХ</h3>
                            <div class="related-websites" style="border: none">
                                <a href="https://www.facebook.com/upath/" target="_blank" ><div class="related-website-icon" style="background-image: url(/static/resources/img/socicon/fb-icon.png);"></div></a>
                                <a href="https://vk.com/upath" target="_blank" style="margin-left: 20px"><div class="related-website-icon" style="background-image: url(/static/resources/img/socicon/vk-icon.jpg);"></div></a>
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
							<h4>Все права защищены © 2002-<?php echo date('Y');?> Ким Майклс</h4>
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
