<div class="cantener">
	<div class="register-main">
	<h1>Messaging</h1>
		<div class="registerPage messaging">
			<div style="margin-bottom: 15px;" class="messagecenter">								
				<?php echo $this->Html->link('Inbox', array('controller' => 'Mail', 'action' => 'index'));?>
				<?php echo $this->Html->link('Sent', array('controller' => 'Mail', 'action' => 'sent'));?>
				<?php echo $this->Html->link('Trash', array('controller' => 'Mail', 'action' => 'trash'));?>																
			</div>
			<?php if (isset($viewMassage)) {?>
				<p><label>From: </label><span><?php echo $viewMassage['Mail']['sender']?></span></p>
				<p><label>Subject:</label><span><?php echo $viewMassage['Mail']['subject']?></span></p>
				<p><label>Message:</label><span style='line-height:18px;'><?php echo $viewMassage['Mail']['message']?></span></p>
				<p style="padding-top:20px;height:50px;line-height:18px;">
					<label>&nbsp;</label>
					<span>						
						<?php echo $this->Html->link('Reply to Message', array('controller' => 'Mail', 'action' => 'compose', 'id' => $viewMassage['Mail']['id'], 'to' => $fullName, 'subject' => 'RE: '.$newSubject, 'userTypeFrom' => $userTypeFrom, 'userTypeTo' => $userTypeTo, 'sender' => $sender), array('class' => "mailaction"));?>	
					</span>
				</p>
            <?php } else {?>    															
			<div class="thankyoumessage" style="margin-top: 10px;">This isn't your mail!</div>
			<?php }?>															
		</div>				
	</div>			
</div>		

