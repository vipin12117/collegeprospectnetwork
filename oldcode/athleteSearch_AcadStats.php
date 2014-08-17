<!-- GPA -->
<p class="alt">
    <label>GPA:</label>
    <span>
        <select name="fldGPA">
            <option value="" class="selectgrey">Any GPA</option>
            <?php echo FormHelper::array2options($gpaList, $fldGPA); ?>
        </select>
    </span>
</p>

<!-- SAT Score -->
<p>
    <label>SAT Score:</label>
    <span>
        <select name="fldSATScore">
            <option value="" class="selectgrey">Any SAT Score</option>
            <?php echo FormHelper::array2options($satList, $fldSATScore); ?>
        </select>                                                      
    </span>
</p>

<!-- ACT Score -->
<p class="alt">
    <label>ACT Score:</label>
    <span>
        <select name="fldACTScore">
            <option value="" class="selectgrey">Any ACT Score</option>
            <?php echo FormHelper::array2options($actList, $fldACTScore); ?>
        </select>
    </span>
</p>

<!-- Class Rank -->
<p>
    <label>Class Rank:</label>
    <span>
        <select name="fldClassRank">
            <option value="" class="selectgrey">Any Class Rank</option>
            <?php
                echo FormHelper::array2options($classRankList, $fldClassRank);
            ?>
        </select>
    </span>
</p>

<!-- Intended Major -->
<p class="alt">
    <label>Intended Major:</label>
    <span>
        <select name="fldIntendedMajor">
            <option value="" class="selectgrey">Any Intended Major</option>
            <?php
                echo FormHelper::array2options($majorList, $fldIntendedMajor);
            ?>
        </select>
    </span>
</p>
