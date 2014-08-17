<!-- HS/AAU Team -->
<p class="alt">
    <label>HS/AAU Team:</label>
    <span>
        <select name="fldSchool">
            <option value="" class="selectgrey">Any HS/AAU Team</option>
            <?php
                echo FormHelper::array2options($schoolList, $fldSchool);
            ?>
        </select>
    </span>
</p>

<!-- State -->
<p>
    <label>State:</label>
    <span>
        <select name="fldState">
            <option value="" class="selectgrey">Any State</option>
            <?php
                echo FormHelper::array2options($stateList, $fldState);
            ?>
        </select>
    </span>
</p>

<!-- ZIP code and Distance -->
<p class="alt">
    <label>ZIP Code:</label>
    <span>
        <input type="text" name="fldZipCode" style="width:80px;margin-right:3px;"
               value="<?php echo $fldZipCode; ?>" />
        within
        <select name="fldDistance" style="width: 95px;margin-right:5px;">
            <option value="any">Any Miles</option>  
            <?php
                echo FormHelper::array2options($distanceList, $fldDistance);
            ?>
        </select>										
    </span>
</p>
