<?php
use Models\User;
use Quark\QuarkModel;
use Quark\QuarkView;
use ViewModels\Admin\Event\CreateView;
/**
 * @var QuarkModel|User $user
 * @var QuarkView|CreateView $this
 * @var QuarkModel|User $item
 */

$item = new QuarkModel(new User);
//print_r($user);
$service = 'create';
if (isset($user)) {
	//echo "<br>";
	//echo "user is : ".$user;
	$item = $user;
	$service = 'edit/' . $item->id;
}
?>
<h1 class="page-title">Add New User</h1>
<h5 class="page-title">Insert data to create an new user</h5>
<form method="POST" id="form" action="/admin/user/<?php echo $service; ?>">
    <div class="quark-presence-column left">
        <div class="quark-presence-container content-container presence-block " id="form-body">
            <div class="quark-presence-column left" id="main_div">
				<div class="quark-presence-container presence-block middle " id="form-div">
					<div class="title"><p>Login</p>
						<input placeholder="Login" type="text" class="text_field quark-input" name="login" id="login" value="<?php echo $item->login; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle additional" id="form-div">
					<div class="title additional"><p>Password</p>
						<input placeholder="Password" type="password" class="text_field quark-input additional" name="password" id="password" value="">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle additional" id="form-div">
					<div class="title additional"><p>Re-Password</p>
						<input placeholder="Re-password" type="password" class="text_field quark-input additional" name="re-password" id="re_password" >
					</div>
				</div>
				<div class="quark-presence-container presence-block  middle" id="form-div">
					<div class="title"><p>Name</p>
						<input placeholder="Name" type="text" class="text_field quark-input" name="name" id="name" value="<?php echo $item->name; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle" id="form-div">
					<div class="title"><p>Email</p>
						<input placeholder="Email" type="text" class="text_field quark-input" name="email" id="email" value="<?php echo $item->email; ?>">
					</div>
				</div>
				<div class="quark-presence-container presence-block middle" id="form-div">
					<div class="title"><p>Rights</p>
					    <select class="text_field quark-input" name="rights" id="rights">
                            <option value="A" <?php echo $item->rights == User::RIGHTS_ADMIN ? 'selected' : '';?>>Admin</option>
                            <option value="E" <?php echo $item->rights == User::RIGHTS_EDITOR ? 'selected' : '';?>>Editor</option>
                        </select>
					</div>
				</div>
			</div>
			<br />
			<div class="quark-presence-container presence-block" id="form-div">
				<br/>
				<button class="quark-button block ok submit-button" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
