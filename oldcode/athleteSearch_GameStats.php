<!-- Game Stats -->
<?php if (!empty($fldSport)): ?>
	<?php if (!empty($fldSportStats)): ?>
		<?php $isAlt = 1; ?>
		<?php foreach ($fldSportStats as $stat => $value): ?>
			<?php
			if ($isAlt) {
				echo '<p class="alt">';
				$isAlt = 0;
			} else {
				echo '<p>';
				$isAlt = 1;
			}
			?>
				<span>
					<label style="width: 200px;" onclick="label2select(this);"><?php echo $stat; ?></label>
					<input type="text" name="fldStatCategories[<?php echo $stat; ?>]" value="<?php echo $value; ?>">
				</span>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>
	<p id="statsBtn">
		<span>
			<input type="button" onclick="addStatsField();" value="Add More">
		</span>
	</p>
	<?php else: ?>                         
	<p>
		<span>
			Select a sport to add game stats
		</span>
	</p>
	<?php endif; ?>