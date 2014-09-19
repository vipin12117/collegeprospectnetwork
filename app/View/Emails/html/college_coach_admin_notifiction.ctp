<?php if ($newCollege) {?>
New College Coach Registration + New College<br />
<?php } else {?>
New College Coach Registration:<br />
<?php }?>

<br /><b>Status:</b> Active - 5 Day Trial Period
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

<br /><b>College:</b>  <?php echo $collegeName ?>
<br /> <?php echo $address['address'] ?>
<br /> <?php echo $address['city']. ", ". $address['state']. " " . $address['zip'] ?>
		
<br /><br /><b>Sport:</b> <?php echo $sportName?>
<br /><b>Division:</b> <?php echo $data['division']?>
<br /><b>Job Position:</b> <?php echo $data['position']?>
				
<br /><br /><?php echo $httpUserAgent?>
