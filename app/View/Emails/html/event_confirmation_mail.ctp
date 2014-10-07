<div>
	<b>Event :</b><?php echo $eventDetail['SpecialEvent']['event_name'];?><br />
	
	<b>Name  :</b><?php $userDetail['SpecialEventUser']['firstname'] . " " . $userDetail['lastname'];?> <br />
	<b>Email  :</b><?php $userDetail['email'];?> <br />
	<b>Address  :</b><?php $userDetail['address'];?> <br />
	<b>Phone  :</b><?php $userDetail['phone'];?> <br />
	<b>City  :</b><?php $userDetail['city'];?> <br />
	<b>State  :</b><?php $userDetail['state'];?> <br />
	
	<b>Graduate Class  :</b><?php $userDetail['class'];?> <br />
	<b>Primary Position  :</b><?php $userDetail['primary_position'];?> <br />
	<b>Secondary Position  :</b><?php $userDetail['secondary_position'];?> <br />
	<b>HS Coach Name  :</b><?php $userDetail['coach_name'];?> <br />
	<b>School  :</b><?php $userDetail['address'];?> <br />
	<b>AAU Coach Name  :</b><?php $userDetail['hs_aau_coach_name'];?> <br />
	
	<b>Coupon Number  :</b><?php $userDetail['coupon_number'];?> <br />
	<b>Referred By  :</b><?php $userDetail['referred_by'];?> <br />
	<b>Transcript  :</b><a href='<?php echo Router::fullBaseUrl().$this->base."/files/".$userDetail['transcript'];?>'>Download Transcript</a> <br />
	
	<b>Event Price :</b> $<?php $userDetail['current_price'];?>
	<b>Transportation :</b> $<?php $userDetail['TransportationDiscount']['transport_charge'];?>
	<b>Early Registration Discount :</b> <?php $early_discount_rate;?>
	<b>Upload Transcipt Discount :</b> <?php $eventDetail['SpecialEvent']['transcript_discount'];?>
	<b>Coupon Discount :</b> <?php $coupon_detail['Coupon']['amount'];?>
	
	<b>Event Total Price :</b> <?php $total_price;?>
	
	<b>Payment Status :</b> <?php $userDetail['SpecialEventUser']['payment_status'];?>
	<b>Tranaction ID :</b> <?php $userDetail['SpecialEventUser']['transaction_id'];?>
</div>