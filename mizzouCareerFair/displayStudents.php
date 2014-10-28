<?php
		include ("data.php");
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
			if (!$conn)
			{
				echo "<br/>An error occurred with connecting to the server.<br/>";
				die();
			}
			echo 'i hate this';
			//if ($_SESSION['employer_loggedin'])
			//{	
				//use pg_num_rows to get amount of rows. Print that many pages with info.	
				//$query = 'SELECT email, COUNT(*) FROM careerSchema.employerScannedStudents';
				$query = 'SELECT * FROM careerSchema.employerScannedStudents';

				//function call to print results of query
				displayResults($query);
			//}
				
		function displayResults($query){

			//gathers query data assigns to result
			$stmt = pg_prepare($conn, "store_info", $query);
			$result = pg_execute($conn, "store_info", $query);
		
			//prints amount of rows returned
			echo "There were <em>" . pg_num_rows($result) . "</em> rows returned\n";
			echo "<br /><br />\n";
			echo "<table border=\"1\"\n>";

			//variables for columns and rows
			$num_fields = pg_num_fields($result);
			$num_rows = pg_num_rows($result);

			echo "<tr>\n";
			for($i=0;$i<$num_fields;$i++)
			{
					//prints column headings
					$fieldname = pg_field_name($result,$i);
					echo "<th>$fieldname</th>\n";

			}
			echo "</tr>";
			//loop gathers query data and stores it in result
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
					echo "<tr>\n";
					//prints data by the line
					foreach ($line as $col_value) {
							echo "<td>$col_value</td>\n";
					}
					echo "</tr>\n";
			}
			echo "</table>\n";
		}
			

		?>