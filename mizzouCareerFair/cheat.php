 <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
  <!--the page shows the content of the tables--->
<title> Cheat sheet</title>
</head>
<body>
<form method="POST" action=" ">
    <input type="submit" name="show" value="show" />
</form>
</body>
<?php
if(isset($_POST['show']))
{
    include ("data.php");
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
	
    $query='SELECT * FROM careerSchema.admininfo';
    $result=pg_query($conn,$query);
    
        echo "number of records".pg_num_rows($result)."so far\n";
        $i=pg_num_fields($result);
        echo "<table>";
        echo "\t<tr>\n";
        for($j=0;$j<$i;$j++)
        {
            $fieldname = pg_field_name($result,$j);
            echo "\t\t<td>\n";
            echo $fieldname;
            echo "\t\t</td>";
        }
        echo "\t</tr>\n";
        while($line=pg_fetch_array($result,NULL,PGSQL_ASSOC))
        {
            echo "\t<tr>\n";
            foreach($line as $col_value)
            {
                echo "\t\t<td>$col_value</td>\n";
            }
            echo "\t</tr>\n";
     }
	 $query2='SELECT * FROM careerSchema.companies';
     $res=pg_query($conn,$query2);
        echo "number of records".pg_num_rows($res)."so far\n";
        $i=pg_num_fields($res);
        echo "<table>";
        echo "\t<tr>\n";
        for($j=0;$j<$i;$j++)
        {
            $fieldname = pg_field_name($res,$j);
            echo "\t\t<td>\n";
            echo $fieldname;
            echo "\t\t</td>";
        }
        echo "\t</tr>\n";
        while($line=pg_fetch_array($res,NULL,PGSQL_ASSOC))
        {
            echo "\t<tr>\n";
            foreach($line as $col_value)
            {
                echo "\t\t<td>$col_value</td>\n";
            }
            echo "\t</tr>\n";
     }
	 $query3='SELECT * FROM careerSchema.rssinfo';
     $smt=pg_query($conn,$query3);

        echo "number of records".pg_num_rows($smt)."so far\n";
        $i=pg_num_fields($smt);
        echo "<table>";
        echo "\t<tr>\n";
        for($j=0;$j<$i;$j++)
        {
            $fieldname = pg_field_name($smt,$j);
            echo "\t\t<td>\n";
            echo $fieldname;
            echo "\t\t</td>";
        }
        echo "\t</tr>\n";
        while($line=pg_fetch_array($smt,NULL,PGSQL_ASSOC))
        {
            echo "\t<tr>\n";
            foreach($line as $col_value)
            {
                echo "\t\t<td>$col_value</td>\n";
            }
            echo "\t</tr>\n";
     }
}
?>
    </html>

