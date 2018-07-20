<fieldset>
    <!-- Form Name -->
	<?php if($edit) : ?>
			<?php if($_SESSION['admin_type']!=='super') : ?>
				<legend>Change Password</legend>
			<?php else : ?>
    			<legend>Update <?php echo $admin_account['user_name'] ?></legend>
			<?php endif; ?>
	<?php else : ?>
				<legend>Add new admin user</legend>
	<?php endif; ?>
		
	    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">User name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<?php if($edit && $_SESSION['admin_type']!=='super') : ?>
               			<input  type="text" name="user_name" placeholder="user name" class="form-control" onkeydown="return false;" value="<?php echo ($edit) ? $admin_account['user_name'] : ''; ?>" autocomplete="off">
				<?php else : ?>
						<input  type="text" name="user_name" placeholder="user name" class="form-control" value="<?php echo ($edit) ? $admin_account['user_name'] : ''; ?>" autocomplete="off">
				<?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" >Password</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="passwd" placeholder="Password " class="form-control" required="" autocomplete="off">
            </div>
        </div>
    </div>

	<?php if(($_SESSION['admin_type']==='super')) : ?>
    	<div class="form-group">
			<label class="col-md-4 control-label">User type</label>
			<div class="col-md-4">
				<div class="radio">
					<label>
						<?php //echo $admin_account['admin_type'] ?>
						<input type="radio" name="admin_type" value="super" required="" <?php echo ($edit && $admin_account['admin_type'] =='super') ? "checked": "" ; ?>/> Administrator
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="admin_type" value="admin" required="" <?php echo ($edit && $admin_account['admin_type'] =='admin') ? "checked": "" ; ?>/> KSEB Operator
					</label>
				</div>
				
			</div>
		</div>
	<?php endif; ?>
    <!-- radio checks -->
    
    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
	<?php
		if(isset($_SESSION['chgpwd']) && $_SESSION['chgpwd'] === TRUE){ ?>
				<div class="alert alert-success alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo '<strong>Success! </strong>Password changed successfully!'; unset($_SESSION['chgpwd']);?>
				
				</div>
				<?php } ?>
</fieldset>