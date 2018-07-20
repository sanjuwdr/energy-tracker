<fieldset>
    <div class="form-group">
        <label for="f_name">First Name *</label>
          <input type="text" name="f_name" value="<?php echo $edit ? $customer['f_name'] : ''; ?>" placeholder="First Name" class="form-control" required="required" id = "f_name" >
		
    </div>

    <div class="form-group">
        <label for="l_name">Last name *</label>
        <input type="text" name="l_name" value="<?php echo $edit ? $customer['l_name'] : ''; ?>" placeholder="Last Name" class="form-control" required="required" id="l_name">
    </div>

    <div class="form-group">
        <label>Gender * </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="male" <?php echo ($edit &&$customer['gender'] =='male') ? "checked": "" ; ?> required="required"/> Male
        </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="female" <?php echo ($edit && $customer['gender'] =='female')? "checked": "" ; ?> required="required" id="female"/> Female
        </label>
	</div>

    <div class="form-group">
        <label for="address">Address</label>
          <input name="address" value="<?php echo $edit ? $customer['address'] : ''; ?>" placeholder="Address" class="form-control" type="text" id="address">
    </div> 

    <div class="form-group">
        <label>District </label>
           <?php $opt_arr = array("Kasaragod", "Kannur", "Wayanad", "Kozhikode","Palakkad", "Thrissur", "Ernakulam", "Idukki", "Malappuram", "Kottayam","Thiruvananthapuram", "Kollam", "Alappuzha", "Pathanamthitta"); 
                            ?>
            <select name="state" class="form-control selectpicker" required>
                <option value=" " >Please select your district</option>
                <?php
                foreach ($opt_arr as $opt) {
                    if ($edit && $opt == $customer['state']) {
                        $sel = "selected";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                }

                ?>
            </select>
    </div>  
    <div class="form-group">
        <label for="email">Email</label>
            <input  type="email" name="email" value="<?php echo $edit ? $customer['email'] : ''; ?>" placeholder="E-Mail Address" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
            <input name="phone" value="<?php echo $edit ? $customer['phone'] : ''; ?>" placeholder="9876543210" class="form-control"  type="text" id="phone">
    </div> 

    <div class="form-group">
        <label>Date of birth</label>
        <input name="date_of_birth" value="<?php echo $edit ? $customer['date_of_birth'] : ''; ?>"  placeholder="Birth date" class="form-control"  type="date">
    </div>
	
	
	<div class="form-group">
		<label>Energy Tracker ID *</label>
		<div class="input-group ">
            <span class="input-group-addon">ET</span>    
            <input type="number" name="id" value="<?php echo $edit ? $customer['id'] : ''; ?>" placeholder="1234" class="form-control" required="required" id="id">
        </div>
    </div>
	

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" ><?php echo $signup ? 'Sign Up' : 'Save' ?> <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>