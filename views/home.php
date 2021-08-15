<?php
include "common/header.php";
?>

<div class="row">

	<div class="col-md-12">
		<div class="form-box">
			<div class="logo col-md-4">
				<img class="img-responsive" src="./assets/images/logo.png" />
			</div>
			<div class="col-md-4">
				<form method="GET" class="cneter-form">
					<div class="form-group">
						<input type="text" autocomplete="off" class="form-control" name="search" value="<?php echo (@$var['search'])? $var['search']:''; ?>" placeholder="Search">
						<?php if(isset($error['amount'])) echo '<span class="error">'.$error['amount'].'</span>' ?>
					</div>
					<div class="form-group text-center">
						<button class="btn btn-primary" value="submit" type='submit'>Search</button>
					</div>
				</form>
			</div>
			<div class="col-md-4">
				<form method="POST">
					<div class="logout-btn">
						<button class="btn btn-primary" name="logout" value="logout" type='submit'>Logout</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="row justify-content-center">
			<div class="">
			<?php if(array_key_exists("list", $var)) {
				if(!empty($var['list'])){
					echo "<div id='slide' class='result'>";
					foreach($var["list"] as $list) {
						echo "<div class='row'>";
						echo "<div class='col-sm-6'>".$list['author']."</div>";
						echo "<div class='col-sm-6'>".((@$list['book'])?:'&lt;none&gt; (no books found)')."</div>";
						echo "</div>";
					}
					echo "</div>";
				}else{
					echo "<div id='slide' class='result text-center'><h5 class='text-center'>No Author found</h5></div>";
				}
			} ?>
			</div>
		</div>
	</div>
</div>


<?php
include "common/footer.php";
?>