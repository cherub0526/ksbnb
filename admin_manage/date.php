<?php
if($_POST['month']!="" && $_POST['year'] !="")
{
	for($i=1;$i<=12;$i++)
	{
		if($_POST['month'] == $i)
		{
			if($i == 1 || $i == 3 || $i == 5 || $i == 7 || $i == 8 || $i == 10 || $i == 12 )
			{
				for($j=1;$j<=31;$j++)
				{
					echo "<option value='";
					if($j<10) echo "0";
					echo $j."'>";if($j<10) echo "0"; echo $j."</option>";
				}
			}
			else if($i == 2)
			{
				if($_POST['year'] % 4 == 0)
				{
					for($j=1;$j<=29;$j++)
					{
						echo "<option value='";
						if($j<10) echo "0";
						echo $j."'>";if($j<10) echo "0"; echo $j."</option>";
					}
				}
				else
				{
					for($j=1;$j<=28;$j++)
					{
						echo "<option value='";
						if($j<10) echo "0";
						echo $j."'>";if($j<10) echo "0"; echo $j."</option>";
					}
				}
				
			}
			else
			{
				for($j=1;$j<=30;$j++)
				{
					echo "<option value='";
					if($j<10) echo "0";
					echo $j."'>";if($j<10) echo "0"; echo $j."</option>";
				}
			}
		}
		
	}
}
?>