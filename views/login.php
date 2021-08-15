<?php
include "common/header.php";
?>

<div class="login-parent">
	<div class="row">
		<div class="col-md-12">
			<div class="form-box">
				<div class="logo logo-main">
					<img class="img-responsive" src="./assets/images/logo.png" />
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-box login-box">
				<form method="POST">
					<div class="form-group">
						<input autocomplete="off" type="text" id="login" class="form-control" name="username" placeholder="Username" value="<?php echo (@$var['username'])? $var['username']:''; ?>" required>
						<?php if(isset($var['error']['username'])) echo '<span class="error">'.$var['error']['username'].'</span>' ?>
					</div>
					<div class="form-group">
					    <input autocomplete="off" type="password" id="password" class="form-control" name="password" placeholder="Password" required>
						<?php if(isset($var['error']['password'])) echo '<span class="error">'.$var['error']['password'].'</span>' ?>
					</div>
					<div class="form-group text-center">
						<button class="btn btn-primary" name="type" value="submit" type="submit">Log In</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
include "common/footer.php";
?>