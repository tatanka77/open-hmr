<?php
	echo "<?xml version='1.0' ?>\n";
	
	// Get parameters
	$sLevel = $_GET["level"];
	$level = 0;
	
	// Verify parameters
	if($sLevel === "4") $level = 4;
	elseif ($sLevel === "3") $level = 3;
	elseif ($sLevel === "2") $level = 2;
	else $level = 1;
	
	// Init paths and vars
	$sPath = realpath(dirname(__FILE__)).'/';
	$sHttpPath = str_replace("/tmp/usbmounts/","http://localhost/media/",$sPath);

	$rows = 9;
	$cols = 9;
	$cells = $rows * $cols;
	$curIdx = (int)($cells / 2);
 
	// Generate an initial grid
	switch (rand(0,3))
	{
		case 0:
			$grid = array(6,2,5,1,3,4,7,8,9,4,3,7,9,2,8,6,5,1,9,8,1,7,6,5,3,4,2,5,6,2,8,7,9,1,3,4,7,1,9,6,4,3,5,2,8,3,4,8,2,5,1,9,6,7,1,5,6,4,9,2,8,7,3,2,9,3,5,8,7,4,1,6,8,7,4,3,1,6,2,9,5);
			break;
		case 1:
			$grid = array(3,2,8,1,4,6,9,5,7,6,1,5,2,9,7,4,8,3,4,7,9,3,5,8,1,2,6,2,5,6,4,7,3,8,9,1,9,4,7,5,8,1,6,3,2,1,8,3,9,6,2,7,4,5,5,6,1,8,3,4,2,7,9,8,9,2,7,1,5,3,6,4,7,3,4,6,2,9,5,1,8);
			break;
		case 2:
			$grid = array(6,5,3,1,7,8,2,9,4,8,2,1,6,9,4,3,7,5,4,9,7,2,3,5,1,8,6,2,8,6,3,5,7,9,4,1,1,3,5,4,6,9,8,2,7,7,4,9,8,2,1,6,5,3,9,1,2,7,4,6,5,3,8,5,7,8,9,1,3,4,6,2,3,6,4,5,8,2,7,1,9);
			break;
		case 3:
			$grid = array(7,2,9,1,3,6,5,8,4,6,3,4,5,2,8,7,9,1,5,8,1,4,7,9,6,2,3,3,4,6,2,1,7,9,5,8,9,1,7,8,5,4,2,3,6,8,5,2,6,9,3,1,4,7,2,6,5,3,4,1,8,7,9,4,7,8,9,6,2,3,1,5,1,9,3,7,8,5,4,6,2);
			break;
	}

	// Scramble grid with permutations of cols and rows
function permcols($a,$b)
{
	global $grid;

	for($i=0; $i<9; $i++)
	{
		$i1 = $a * 9 + $i;
		$i2 = $b * 9 + $i;
		$tmp = $grid[$i1];
		$grid[$i1] = $grid[$i2];
		$grid[$i2] = $tmp;
	}
}

function permrows($a,$b)
{
	global $grid;

	for($i=0; $i<9; $i++)
	{
		$i1 = $a + $i * 9;
		$i2 = $b + $i * 9;
		$tmp = $grid[$i1];
		$grid[$i1] = $grid[$i2];
		$grid[$i2] = $tmp;
	}
}

for($i=0; $i<1000; $i++)
{
	switch (rand(0,23))
	{
		case 0:
			permrows(0,3); permrows(1,4); permrows(2,5);
			break;
		case 1:
			permrows(0,6); permrows(1,7); permrows(2,8);
			break;
		case 2:
			permrows(6,3); permrows(7,4); permrows(8,5);
			break;
		case 3:
			permrows(0,1);
			break;
		case 4:
			permrows(0,2);
			break;
		case 5:
			permrows(1,2);
			break;
		case 6:
			permrows(3,4);
			break;
		case 7:
			permrows(3,5);
			break;
		case 8:
			permrows(4,5);
			break;
		case 9:
			permrows(6,7);
			break;
		case 10:
			permrows(6,8);
			break;
		case 11:
			permrows(7,8);
			break;
		case 12:
			permcols(0,3); permcols(1,4); permcols(2,5);
			break;
		case 13:
			permcols(0,6); permcols(1,7); permcols(2,8);
			break;
		case 14:
			permcols(6,3); permcols(7,4); permcols(8,5);
			break;
		case 15:
			permcols(0,1);
			break;
		case 16:
			permcols(0,2);
			break;
		case 17:
			permcols(1,2);
			break;
		case 18:
			permcols(3,4);
			break;
		case 19:
			permcols(3,5);
			break;
		case 20:
			permcols(4,5);
			break;
		case 21:
			permcols(6,7);
			break;
		case 22:
			permcols(6,8);
			break;
		case 23:
			permcols(7,8);
			break;
	}
}

// Select cells displayed regarding difficulty level
for($i=0; $i<$cells; $i++) $base[] = 0;
for($i=0; $i<3; $i++)
{
	for($j=0; $j<3; $j++)
	{
		for($k=0; $k<(6-$level); $k++)
		{
			$l = rand(0,8);
			$l1 = (int) $l/3;
			$l2 = (int) $l%3;
			$base[($i*3) + ($j*27) + ($l1*9) + $l2] = 1;
		}
	}
}
for($i=0; $i<(10-2*$level); $i++) $base[rand(0,80)] = 1;


?>

<rss version='2.0' xmlns:media='http://purl.org/dc/elements/1.1/' xmlns:dc='http://purl.org/dc/elements/1.1/'>

<!-- Init of gridArray, baseArray, userArray -->
<?php	
	echo "<script>\n";
	echo "gridArray=null;\n";
	echo "baseArray=null;\n";
	echo "userArray=null;\n";
	for($i=0; $i<$cells ; $i++)
	{
		echo "gridArray=pushBackStringArray(gridArray, \"$grid[$i]\");\n";
		echo "baseArray=pushBackStringArray(baseArray, \"$base[$i]\");\n";
		if($base[$i] == 1)
		{
			echo "userArray=pushBackStringArray(userArray, \"$grid[$i]\");\n";
		}
		else
		{
			echo "userArray=pushBackStringArray(userArray, \"0\");\n";
		}
	}
	echo "</script>\n";
?>

<test>
	solved = "true";
	tmpArray = null;

<?php
	for($i=0; $i<$cells; $i++)
	{
		echo <<<TEST

		if(getStringArrayAt(baseArray,$i) == "0")
		{
			if($i == curIdx)
				tmpArray = pushBackStringArray(tmpArray, userInput);
			else
				tmpArray = pushBackStringArray(tmpArray, getStringArrayAt(userArray,$i));
		}
		else
		{
			tmpArray = pushBackStringArray(tmpArray, getStringArrayAt(gridArray,$i));
		}
		if(getStringArrayAt(userArray,$i) != getStringArrayAt(gridArray,$i)) solved = "false";

TEST;
	}

?>

	userArray = tmpArray;

</test>


<!-- Init RSS vars -->
<onEnter>
	
	cells = <?= $cells ?>;
	rows = <?= $rows ?>;
	rowsM1 = minus(rows,1);
	curIdx = <?= $curIdx ?>;
	low = minus(cells , rows);
	high = minus(cells , 1);
	displayErrors = "false";
	displaySolution = "false";
	solved = "false";
	redrawDisplay();

</onEnter>


<!-- mediaDisplay  START -->
<mediaDisplay name="photoView"

	showHeader="no"
	sideTopHeightPC="0"
	sideBottomHeightPC="0"
	sideLeftWidthPC="0"
	sideRightWidthPC="100"
	bottomYPC="100"

	rowCount="<?= $rows ?>"
	columnCount="<?= $cols ?>"
	itemOffsetXPC="20"
	itemOffsetYPC="0"
	itemGapXPC="0"
	itemGapYPC="0"
	itemXPC = "1"
	itemYPC = "0"
	itemAlign="center"
	>

<!-- onUserInput -->
<onUserInput>

	ret = "false";
	displayErrors = "false";
	displaySolution = "false";

	userInput = currentUserInput();

	if( solved == "false")
	{
		if( userInput == "L")
		{
			if (curIdx &gt;= rows)
			{
				curIdx = minus(curIdx,rows);
				redrawDisplay();
				ret = "true";
			}
		}

		if( userInput == "R")
		{
			if (curIdx &lt; low)
			{
				curIdx = add(curIdx,rows);
				redrawDisplay();
				ret = "true";
			}
		}

		if( userInput == "U")
		{
			modulo = Integer(curIdx%rows);
			if(modulo &gt; 0)
			{
				curIdx = minus(curIdx,1);
				redrawDisplay();
				ret = "true";
			}
		}

		if( userInput == "D")
		{
			modulo = Integer(curIdx%rows);
			if(modulo &lt; rowsM1)
			{
				curIdx = add(curIdx,1);
				redrawDisplay();
				ret = "true";
			}
		}
		
		if( (userInput == "0") || (userInput == "1") || (userInput == "2") || (userInput == "3") || (userInput == "4")|| (userInput == "8"))
		{
			executeScript("test");
			redrawDisplay();
			ret = "true";
		}
		if(userInput == "video_search")
		{
			userInput = "5";
			executeScript("test");
			redrawDisplay();
			ret = "true";
		}
		if(userInput == "setup")
		{
			userInput = "7";
			executeScript("test");
			redrawDisplay();
			ret = "true";
		}
		if (userInput == "PG")
		{
			userInput = "6";
			executeScript("test");
			redrawDisplay();
			ret = "true";
		}
		if (userInput == "PD")
		{
			userInput = "9";
			executeScript("test");
			redrawDisplay();
			ret = "true";
		}
		
		if (userInput == "DISPLAY")
		{
			displayErrors = "true";
			redrawDisplay();
			ret = "true";
		}

		if (userInput == "video_play")
		{
			displaySolution = "true";
			redrawDisplay();
			ret = "true";
		}
	}

	ret;
</onUserInput>


<!-- itemDisplay -->
<itemDisplay>
	<script>
		itemIdx = getQueryItemIndex();
		grid = getStringArrayAt(gridArray,itemIdx);
		base = getStringArrayAt(baseArray,itemIdx);
		user = getStringArrayAt(userArray,itemIdx);
	</script>
	<text redraw=yes align=center offsetXPC=5 offsetYPC=5 widthPC=90 heightPC=90 fontSize=30>
		<backgroundColor>
			<script>
				if(itemIdx == curIdx)
					"50:25:25";
				else
					"20:20:20";
			</script>
		</backgroundColor>
		<foregroundColor>
			<script>
				if(base == "1")
					"150:150:150";
				else if((displayErrors == "true") &amp;&amp; (user != grid))
					"200:50:50";
				else
					"50:100:175";
			</script>
		</foregroundColor>
		<script>
			if(displaySolution == "false")
			{
			if(user == "0")
				"";
			else
				user;
			}
			else
				grid;
		</script>
	</text>

</itemDisplay>

<image redraw=yes offsetXPC=17.5 offsetYPC=0 widthPC=60 heightPC=100><?= $sPath."grid.png" ?></image>

</mediaDisplay>
<!-- mediaDisplay  END -->


<!-- channel -->
<channel>
	<title>xPuzzle</title>

<?php
	for($i=0; $i<$cells; $i++)
		echo "<item><title>$i</title></item>\n";
?>

</channel>

</rss>

