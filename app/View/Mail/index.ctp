<div class="cantener">
	<div class="register-main">
	<h1>Messaging</h1>
		<div class="registerPage messaging">
			<div style="margin-bottom: 15px;" class="messagecenter">								
				<?php echo $this->Html->link('Inbox', array('controller' => 'Mail', 'action' => 'index'), array('class' => "active"));?>
				<?php echo $this->Html->link('Sent', array('controller' => 'Mail', 'action' => 'sent'));?>
				<?php echo $this->Html->link('Trash', array('controller' => 'Mail', 'action' => 'trash'));?>																
			</div>
			<?php if (!empty($inboxMassages)) {?>
			<table cellpadding=2 cellspacing=1 width='100%'  align='center'>
				<tr>
					<td align="left" class="normalblack_12" width="10%"><strong>Date</strong></td>
	                <td align="left" class="normalblack_12" width="45%"><strong>Subject</strong></td>
	                <td align="left" class="normalblack_12" width="30%"><strong>From User</strong></td>
	                <td class="normalblack_12" width="15%" align="center" style="text-align:center;"><strong>Send to Trash</strong></td>
                </tr>
                <?php foreach ($inboxMassages as $inboxMassage) {?>
                <tr>                	
                	<td align="left" class="normalblack_12" ><?php echo $inboxMassage['Mail']['sent_date']?></td>
                	<td align="left" class="normalblack_12" ><?php echo $this->Html->link($inboxMassage['Mail']['subject'], array('controller' => 'Mail', 'action' => 'view', $inboxMassage['Mail']['id']))?></td>
                	<td align="left" class="normalblack_12" ><?php echo $this->Html->link($inboxMassage['Mail']['sender'], array('controller' => 'College', 'action' => 'view')).' - ('.$inboxMassage['Mail']['usertype_from'].')'?></td>                	
                	<td align="center" class="normalblack_12" style="text-align:center;">                	
                	<?php echo $this->Html->link($this->Html->image('/images/trash_16x16.gif'), array('controller'=>'Mail', 'action'=>'delete', $inboxMassage['Mail']['id']), array('escape' => false), "Are you sure you want to Send Message to Trash?");?>
                	</td>                	                	
                </tr>
                <?php }?>
            </table>
            <?php } else {?>    															
			<div class="thankyoumessage" style="margin-top: 10px;">Your Inbox is Empty!</div>
			<?php }?>															
		</div>				
	</div>			
</div>		

