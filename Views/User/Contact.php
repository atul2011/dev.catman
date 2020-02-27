<?php
use Models\Article;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\User\ContactView;

/**
 * @var QuarkModel|Article $item
 * @var QuarkView|ContactView $this
 */
?>
<div class="block-center__left js-equal-height">
	<div class="item-head">
		<h3 class="main-headline item-main-headline" id="content-title"><?php echo $item->title;?></h3>
	</div>
	<hr class="cm-delimiter cm-header-content-delimiter">
	<div class="item-content">
		<div class="item-content-container">
			<form class="contact-form" enctype="multipart/form-data" action="/user/contact" method="POST">
				<div class="contact-form-container">
					<div class="contact-form-item contact-form-title">
						<?php echo $item->txtfield;?>
					</div>
					<br />
					<div  class="contact-form-item contact-form-field">
						<input name="name" class="contact-form-input" type="text" placeholder="Имя">
					</div>
					<br />
					<div class="contact-form-item contact-form-field">
						<input name="email" class="contact-form-input" type="text" placeholder="Эл. адрес">
					</div>
					<br />
					<div class="contact-form-item contact-form-field">
						<input name="subject" class="contact-form-input" type="text" placeholder="Тема">
					</div>
					<br />
					<div class="contact-form-item contact-form-field">
						<textarea name="text" class="contact-form-input" placeholder="Сообщение"></textarea>
					</div>
					<br class="jp-captcha"/>
					<div class="contact-form-item contact-form-field" id="jp-captcha">
						<div class="g-recaptcha" data-sitekey="<?php echo $this->LocalSettings('GOOGLE_CAPTCHA_KEY');?>"></div>
					</div>
					<br />
					<div  class="contact-form-item contact-form-submit">
						<button type="submit" class="contact-form-button">Отправить сообщение</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>