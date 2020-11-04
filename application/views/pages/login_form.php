<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h5 class="text-center">Please Login Here</h5>
		<?php echo validation_errors('<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?php echo form_open('verifylogin'); ?>
			<div class="form-group">
				<label>Username</label>
				<INPUT type="text" class="form-control" name="username" id="username">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default">Sign In</button>
			</div>
		</form>
	</div>
	<div class="col-md-4"></div>
</div>