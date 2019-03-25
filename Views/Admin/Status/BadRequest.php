<?php
/**
 * @var array $errors
 */
?>
<div class="quark-presence-column center">
	<div class="quark-presence-container status-code">
		<h1>Status 400: Bad Request</h1>
	</div>
	<div class="quark-presence-container status-message">
		<?php
        if (isset($errors) && sizeof($errors) > 0) {
	        foreach ($errors as $error) {
	            echo '<h3>' . $error . '</h3>';
            }
        }
        else
            echo '<h3>Your request are wrong. Please check your input data.</h3>';
        ?>
	</div>
</div>