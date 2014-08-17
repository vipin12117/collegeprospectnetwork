<!-- Max 40-yard Dash (sec) -->
<p class="alt">
    <label>40-yard Dash:</label>
    <span>
        <input name="fld40_yardDash" type="text" class="maskNumericFloat"
               value="<?php echo $fld40_yardDash; ?>"
        >
        <span class="description">seconds or faster</span>
    </span>
</p>

<!-- Max Shuttle Run (sec) -->
<p>
    <label>Shuttle Run:</label>
    <span>
        <input name="fldShuttleRun" type="text" class="maskNumericFloat"
               value="<?php echo $fldShuttleRun; ?>"
        >
        <span class="description">seconds or faster</span>
    </span>
</p>        

<!-- Min Vertical Jump (inches) -->
<p class="alt">
    <label>Vertical Jump:</label>
    <span>
        <input name="fldVertical" type="text" class="maskNumeric"
               value="<?php echo $fldVertical; ?>"
        >
        <span class="description">inches or higher</span>
    </span>
</p>                                        

<!-- Min Bench Press (lbs) -->
<p>
    <label>Bench Press:</label>
    <span>
        <input name="fldBenchPressMax" type="text" class="maskNumeric"
               value="<?php echo $fldBenchPressMax; ?>"
        >
        <span class="description">lbs or heaver</span>
    </span>
</p>

<!-- Min Squat Max (lbs) -->
<p class="alt">
    <label>Squat Max:</label>
    <span>
        <input name="fldSquatMax" type="text" class="maskNumeric"
               value="<?php echo $fldSquatMax; ?>"
        >
        <span class="description">lbs or heaver</span>
    </span>
</p>
