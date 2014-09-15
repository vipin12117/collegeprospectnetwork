<?php

class Mail extends AppModel{

	public $name = 'Mail';

	public $useTable = 'mails';
	
	public $validate = array(
		'receiver' => array(
					'rule'     => 'alphaNumeric',
					'message'    => 'Please select the Receiver (To)',
					'required'   => true,
					'allowEmpty' => false
		),
		'subject' => array(
					'rule'     => 'alphaNumeric',
					'message'    => 'Please enter the Subject',
					'required'   => true,
					'allowEmpty' => false
		),
		'message' => array(
					'rule'     => 'alphaNumeric',
					'message'    => 'Please enter the Message',
					'required'   => true,
					'allowEmpty' => false
		)
	);
	
}