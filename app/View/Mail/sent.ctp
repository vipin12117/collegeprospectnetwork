<div class="cantener">
	<div class="register-main">
	<h1>Messaging</h1>
		<div class="registerPage messaging">
			<div style="margin-bottom: 15px;" class="messagecenter">
				<?php echo $this->Html->link('Inbox', array('controller' => 'Mail', 'action' => 'index'));?>                					
				<?php echo $this->Html->link('Sent', array('controller' => 'Mail', 'action' => 'sent'), array('class' => "active"));?>
				<?php echo $this->Html->link('Trash', array('controller' => 'Mail', 'action' => 'trash'));?>																
			</div>
			<?php if (!empty($sentMassages)) {?>
			<table cellpadding=2 cellspacing=1 width='100%'  align='center'>
				<tr>
					<td align="left" class="normalblack_12" width="10%"><strong>Date</strong></td>
	                <td align="left" class="normalblack_12" width="45%"><strong>Subject</strong></td>
	                <td align="left" class="normalblack_12" width="30%"><strong>To User</strong></td>
                </tr>
                <?php foreach ($sentMassages as $sentMassage) {?>
                <tr>                	
                	<td align="left" class="normalblack_12" ><?php echo $sentMassage['Mail']['sent_date']?></td>
                	<td align="left" class="normalblack_12" ><?php echo $this->Html->link($sentMassage['Mail']['subject'], array('controller' => 'Mail', 'action' => 'viewsent', $sentMassage['Mail']['id']))?></td>
                	<td align="left" class="normalblack_12" ><?php echo $this->Html->link($sentMassage['Mail']['receiver'], array('controller' => 'Athlete', 'action' => 'view', $sentMassage['Mail']['id'])).' - ('.$sentMassage['Mail']['usertype_to'].')'?></td>                	                	                	
                </tr>
                <?php }?>
            </table>
            <?php } else {?>    															
			<div class="thankyoumessage" style="margin-top: 10px;">You have not Sent any messages</div>
			<?php }?>															
		</div>				
	</div>			
</div>		

