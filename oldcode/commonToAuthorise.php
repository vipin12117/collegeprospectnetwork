<?php

 		// Include AuthnetCIM class. Nothing works without it!
		require('AuthnetARB.class.php');
		
		
		
		$cardno=$_POST['x_card_num'];
		
		for($sk=0;$sk<count($costList);$sk++)
		{
			
			if($costList[$sk]['fldId']==$_POST['x_amount'])
			{
			
			$amount=$costList[$sk]['fldCost'];
			$subscription_id=$costList[$sk]['fldId'];
			$fldPeriod =$costList[$sk]['fldPeriod'];
			if($fldPeriod=="Monthly")
			{
				$interval_length=1;
			}	
			elseif ($fldPeriod=="Quaterly")
			{
				$interval_length=3;
			}
			elseif ($fldPeriod=="Yearly")
			{
				$interval_length=12;
			}	
			}
		}
		$expirationDate=$_POST['month']."/".$_POST['year'];
		$first_name=$_POST['x_first_name'];
		$last_name=$_POST['x_first_name'];
		$address=$_POST['x_address'];
		$city=$_POST['x_city'];
		$state=$_POST['x_state'];
		$zip=$_POST['x_zip'];
		$email=$_POST['fldEmail'];
		$subscription_id_responce_cancel=$_POST['subscription_id_responce_cancel'];
		
		// Use try/catch so if an exception is thrown we can catch it and figure out what happened
		try
		{
		    // Set up the subscription. Use the developer account for testing..
		    //$subscription = new AuthnetARB('7WfXTrhR65Kw', '2a77k4L85uNsL3Uy', AuthnetARB::USE_DEVELOPMENT_SERVER);8FVwN499xm
		    $subscription = new AuthnetARB('8FVwN499xm', '2Tc8f298B76jG9yX');
		    // Set subscription information
		    
		    $subscription->setParameter('amount',$amount);
		    $subscription->setParameter('cardNumber',$cardno );
		    $subscription->setParameter('expirationDate', $expirationDate);
		    $subscription->setParameter('firstName', $first_name);
		    $subscription->setParameter('lastName', $last_name);
		    $subscription->setParameter('address',$address);
		    $subscription->setParameter('city', $city);
		    $subscription->setParameter('state', $state);
		    $subscription->setParameter('zip', $zip);
		    $subscription->setParameter('customerEmail', $email);
		    // Set the billing cycle for every three months
		    $subscription->setParameter('interval_length', $interval_length);
		    $subscription->setParameter('startDate', date("Y-m-d"));
		    // Set up a trial subscription for three months at a reduced price
		    //$subscription->setParameter('trialOccurrences', 3);
		    //$subscription->setParameter('trialAmount', 10.00);$subscription_id_responce_cancel
		    // Create the subscription
		    
		    $subscription->createAccount();
		   
		    

		    if ($subscription->isSuccessful()){
		         $subscription_id_responce = $subscription->getSubscriberID();
		       // echo $subscription_id_responce;
		    }
		    else{
		    	
    				  $subcription_Response= $subscription->getResponse();
    				
		    }
		    
		   /* if($subscription_id_responce_cancel)
		    {echo "hello hi error";
		    	$subscription->setParameter('subscrId',$subscription_id_responce_cancel );
		    	$subscription->deleteAccount();
		    	if ($subscription->isSuccessful()){
		        
		       echo $subscription->isSuccessful();
		    }
		    else{
		    	
    				 echo $subscription->getResponse();
    				
		    }
		    }*/
		}
		catch (AuthnetARBException $e){
			
			$subscription = new AuthnetARB('8FVwN499xm', '2Tc8f298B76jG9yX');
			 if($subscription_id_responce_cancel)
		    {
		    	$subscription->setParameter('subscrId',$subscription_id_responce_cancel );
		    	$subscription->deleteAccount();
		    	if ($subscription->isSuccessful()){
		        
		       $Subscription_cancel= "Subscription has been cancel";
		       $flag=1;
		    }
		   
		    }
		     $e1=$e;
		    
		    
		}
		
		
		
 
?>	