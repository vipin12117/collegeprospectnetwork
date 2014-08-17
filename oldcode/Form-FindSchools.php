
<? $country=intval($_GET['country']);
$link = mysql_connect('localhost', 'root', ''); //changet the configuration in required
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('db_ajax');
$query="SELECT id,statename FROM state WHERE countryid='$country'";
$result=mysql_query($query);

?>
<select name="state" onchange="getCity(<?=$country?>,this.value)">
<option>Select State</option>
<? while($row=mysql_fetch_array($result)) { ?>
<option value=<?=$row['id']?>><?=$row['statename']?></option>
<? } ?>
</select>
