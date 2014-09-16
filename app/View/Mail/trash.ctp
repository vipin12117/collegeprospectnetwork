<div class="cantener">
	<div class="register-main">
	<h1>Messaging</h1>
		<div class="registerPage messaging">
			<div style="margin-bottom: 15px;" class="messagecenter">
				<?php echo $this->Html->link('Inbox', array('controller' => 'Mail', 'action' => 'index'));?>
				<?php echo $this->Html->link('Sent', array('controller' => 'Mail', 'action' => 'sent'));?>
				<?php echo $this->Html->link('Trash', array('controller' => 'Mail', 'action' => 'trash'), array('class' => "active"));?>
			</div>
			<?php if (!empty($trashMassages)) {?>
			<table cellpadding=2 cellspacing=1 width='100%'  align='center'>
				<tr>
					<td align="left" class="normalblack_12" width="10%"><strong>Date</strong></td>
	                <td align="left" class="normalblack_12" width="45%"><strong>Subject</strong></td>
	                <td class="normalblack_12" width="10%" align="center" style="text-align:center;"><strong>Delete</strong></td>
                </tr>
                <?php foreach ($trashMassages as $trashMassage) {?>
                <tr>                	
                	<td align="left" class="normalblack_12" ><?php echo $trashMassage['Mail']['sent_date']?></td>
                	<td align="left" class="normalblack_12" ><?php echo $this->Html->link($trashMassage['Mail']['subject'], array('controller' => 'Mail', 'action' => 'veiwtrash', $trashMassage['Mail']['id']))?></td>
					<td align="center" class="normalblack_12" style="text-align:center;">
                	<?php echo $this->Html->link($this->Html->image('/images/b_drop.png'), array('controller'=>'Mail', 'action'=>'deleteconfirm', $trashMassage['Mail']['id']), array('escape' => false), "Are you sure you want to Permanently Delete Message? This cannot be undone.");?>
                	</td>                	                	                	
                </tr>
                <?php }?>
            </table>
            <?php } else {?>    															
			<div class="thankyoumessage" style="margin-top: 10px;">You have no Messages in your Trash</div>
			<?php }?>															
		</div>				
	</div>			
</div>		

