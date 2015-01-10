Thanks for registering
<?php if ($newSchool) {?>
New Athlete Registration + New School:<br />
<?php } else {?>
New Athlete Registration:<br />
<?php }?>

<br /><b>Status:</b> Waiting Approval by HS Coach
<br /><b>Username:</b> <?php echo $data['username']?>
<br /><b>Password:</b> <?php echo $data['password']?>
<br /><b>Name:</b> <?php echo $data['firstname']." ".$data['lastname']?>
<br /><b>Email:</b> <?php echo $data['email']?>
<br />
<br /><b>State:</b> <?php echo $address['state']?>

<br /><b>HS/AAU:</b> <?php echo $highSchoolName ?>
<br /> <?php echo $address['address']?>
<br /> <?php echo $address['city'].", ".$address['state']." ".$address['zip']?> 

<br /><br /><b>Sport:</b> <?php echo $sportName?>
<br /><b>Jersey Number:</b> <?php echo $data['jersey_number']?>
<br /><b>Graduating Class:</b> <?php echo $data['class']?>
<br /><b>Intended Major:</b> <?php echo $data['intended_major']?>
<br /><br /><?php echo $httpUserAgent?>