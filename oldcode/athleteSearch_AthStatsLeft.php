<!-- Sport -->
<?php if (count($sportList) == 1): ?>
	 <input name="fldSport" type="hidden" value="<?php echo $fldSport; ?>" />
<?php else: ?>
	<p class="alt">
        <label>Sport:</label>
        <span>
            <select name="fldSport">
            <option value="" class="selectgrey">Select a Sport</option>
                <?php
                    echo FormHelper::array2options($sportList);
                ?>
            </select>
        </span>
    </p>
<?php endif; ?>

<!-- Graduating Class -->
<?php if (count($sportList) == 1): ?>
    <p class="alt">
<?php else: ?>
    <p>
<?php endif; ?>
    <label>Graduating Class:</label>
    <span>
        <select name="fldClass">
            <option value="" class="selectgrey">Any Class</option>
            <?php
                echo FormHelper::array2options($classList, $fldClass);
            ?>
        </select>
    </span>
</p>

<!-- Division -->
<?php if (count($sportList) == 1): ?>
    <p>
<?php else: ?>
    <p class="alt">
<?php endif; ?>
    <label>Division:</label>
    <span>
        <select name="fldDivision">
            <option value="" class="selectgrey">Any Division</option>
            <?php
                echo FormHelper::array2options($divisionList, $fldDivision);
            ?>
        </select>
    </span>
</p>

<!-- Height -->
<?php if (count($sportList) == 1): ?>
    <p class="alt">
<?php else: ?>
    <p>
<?php endif; ?>
    <label>Height:</label>
    <span>
        <select name="fldMinHeight">
            <option value="" class="selectgrey">Any Min Height</option>
            <?php
                echo FormHelper::array2options($heightList, $fldMinHeight);
            ?>
        </select>
    </span>
    <span style="padding-top:3px;">
        <select name="fldMaxHeight">
            <option value="" class="selectgrey">Any Max Height</option>
            <?php
                echo FormHelper::array2options($heightList, $fldMaxHeight);
            ?>
        </select>
    </span>
</p>

<!-- Weight -->
<?php if (count($sportList) == 1): ?>
    <p>
<?php else: ?>
    <p class="alt">
<?php endif; ?>
    <label>Weight:</label>
    <span>
        <select name="fldMinWeight">
            <option value="" class="selectgrey">Any Min Weight</option>
            <?php
                echo FormHelper::array2options($weightList, $fldMinWeight);
            ?>
        </select>
    </span>
    <span style="padding-top:3px;">
        <select name="fldMaxWeight">
            <option value="" class="selectgrey">Any Max Weight</option>
            <?php
                echo FormHelper::array2options($weightList, $fldMaxWeight);
            ?>
        </select>
    </span>
</p>

<!-- Positions -->
<?php if (count($sportList) == 1): ?>
    <p class="alt">
<?php else: ?>
    <p>
<?php endif; ?>
    <label>Sport Position:</label>
    <span>
        <select name="fldPrimaryPosition">
            <option value="" class="selectgrey">Any Primary Position</option>
            <?php
                echo FormHelper::array2options(
                    $positionList,
                    $fldPrimaryPosition
                );
            ?>
        </select>
    </span>
    <span style="padding-top:3px;">
        <select name="fldSecondaryPosition">
            <option value="" class="selectgrey">Any Secondary Position</option>
            <?php
                echo FormHelper::array2options(
                    $positionList,
                    $fldSecondaryPosition
                );
            ?>
        </select>
    </span>
</p>
