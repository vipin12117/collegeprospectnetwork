<div class="cantener">
	<div class="register-main">
	<h1>Messaging</h1>
		<div class="registerPage messaging">
			<div style="margin-bottom: 15px;" class="messagecenter">								
				<?php echo $this->Html->link('Inbox', array('controller' => 'Mail', 'action' => 'index'));?>
				<?php echo $this->Html->link('Sent', array('controller' => 'Mail', 'action' => 'sent'));?>
				<?php echo $this->Html->link('Trash', array('controller' => 'Mail', 'action' => 'trash'));?>																
			</div>
			<?php echo $this->Form->create();?>
			<p><label>To:</label><span><input type=text name=receiver size=40 class='displaynormal' value=<?php echo (isset($receiver) ? $receiver : '') ?> ><input type=hidden name=sender size=40 value=<?php echo (isset($sender) ? $sender : '') ?>></span></p>			
			<p><label>Subject:</label><span><input type=text name=subject size=40 value=<?php echo (isset($subject) ? '"'.$subject.'"' : '') ?>></span></p>
			<p><label>Message:</label><span><textarea name=message class=ta2><?php echo (isset($message) ? $message : '') ?></textarea></span></p>
			<input type='hidden' name='isSubmit' value='save'>
			<p><label>&nbsp;</label><span><button type=submit onsubmit='' class='btn'>Send Message</button></span></p>
			<?php echo $this->Form->end;?>
		</div>				
	</div>			
</div>		
<script>
	
</script>
