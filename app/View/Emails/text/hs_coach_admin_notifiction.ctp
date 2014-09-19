<?php if ($newSchool) {?>
New HS Coach Registration + New School:<br />
<?php } else {?>
New HS Coach Registration:<br />
<?php }?>

<br /><b>Status:</b> Active
<br /><b>Username:</b>  <?php echo $data['username'] ?>
<br /><b>Password:</b>  <?php echo $data['password'] ?>
<br /><b>Name:</b>   <?php echo $data['firstname']?>&nbsp;<?php echo $data['lastname']?>
<br /><b>Email:</b>  <?php echo $data['email']?>
<br /><b>Alt Email:</b>  <?php echo $data['email2']?>
<br /><b>Phone:</b>  <?php echo $data['phone']?>
<br /><b>Alt Phone:</b>   <?php echo $data['phone2']?>
<br />
<br /><b>State:</b> <?php echo $address['state']?>

<br /><b>HS/AAU:</b> <?php echo $highSchoolName ?>
<br /> <?php echo $address['address'] ?>
<br /> <?php echo $address['city']. ", ". $address['state']. "&nbsp;" . $address['zip'] ?>
		
<br /><br /><b>Sport(s):</b>
<?php	foreach($sportPositions as $sportPosition){?>
			<?php echo $sportPosition['sport_id']. ": " . $sportPosition['position']?><br />
<?php   } ?>
				
<br /><br /><?php echo $httpUserAgent?>
