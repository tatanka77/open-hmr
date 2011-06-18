<?php
	echo "<?xml version='1.0' ?>\n";
	
	// Get parameters
	$size = $_GET["size"];
	$image = $_GET["image"];
	$lang = $_GET["lang"];
	
	// Verify parameters
	if($size === "3x4")
	{
		$rows = 3;
		$cols = 4;
	}
	elseif($size === "4x7")
	{
		$rows = 4;
		$cols = 7;
	}
	elseif($size === "4x6")
	{
		$rows = 4;
		$cols = 6;
	}
	else
	{
		$size = "3x5";
		$rows = 3;
		$cols = 5;
	}
	
	// Init paths and vars
	$sPath = realpath(dirname(__FILE__)).'/';
	$sHttpPath = str_replace("/tmp/usbmounts/","http://localhost/media/",$sPath);
	$sImagePath = $sPath.'images/';
	$sTmpPath = $sPath.'tmp/';
	$sSrcImage = $sImagePath.$image;
	$cells = $rows * $cols;
	$curIdx = $cells - 1;
	$nextIdx = $curIdx;
 
	// Try to open image 
	$im = imagecreatefromjpeg($sSrcImage);

	// Create cells image 
	if($im)
	{
		$tmpWidth = imagesx($im) / $cols;
		$tmpHeight = imagesy($im) / $rows;
		$tmpIm  = imagecreatetruecolor($tmpWidth, $tmpHeight);
		$loc  = imagecolorallocate($im, 50, 50, 50);
		$hic  = imagecolorallocate($im, 150, 150, 150);
		
		for($i=0; $i<$cells; $i++)
		{
			imagecopyresized($tmpIm, $im, 0, 0, ((int)($i / $rows))* $tmpWidth , ($i % $rows)* $tmpHeight, $tmpWidth, $tmpHeight, $tmpWidth, $tmpHeight);
			imagefilledrectangle($tmpIm, 0, 0, 2, $tmpHeight, $hic);
			imagefilledrectangle($tmpIm, 0, 0, $tmpWidth, 2, $hic);
			imagefilledrectangle($tmpIm, $tmpWidth - 3, 0, $tmpWidth, $tmpHeight, $loc);
			imagefilledrectangle($tmpIm, 0, $tmpHeight - 3, $tmpWidth, $tmpHeight, $loc);
			$sTmpFile = sprintf('%s%d.jpg',$sTmpPath,$i);
			imagejpeg($tmpIm, $sTmpFile);
		}
		
		imagedestroy($tmpIm);
		imagedestroy($im);
	}

	// Init $scrambleArray
	for($i=0; $i<$cells; $i++) $scrambleArray[] = $i;
	for($i=0; $i<($cells * 10); $i++)
	{
		switch (rand(0,3))
		{
			case 0: // RIGHT
				if ($curIdx >= $rows) $nextIdx = $curIdx - $rows;
				break;

			case 1: // LEFT
				if ($curIdx < ($cells - $rows)) $nextIdx = $curIdx + $rows;
				break;

			case 2: // DOWN
				if (($curIdx % $rows) > 0) $nextIdx = $curIdx - 1;
				break;

			case 3: // UP
				if (($curIdx % $rows) < ($rows - 1)) $nextIdx = $curIdx + 1;
				break;
		}
		if($nextIdx != $curIdx)
		{
			$tmp = $scrambleArray[$nextIdx];
			$scrambleArray[$nextIdx] = $scrambleArray[$curIdx];
			$scrambleArray[$curIdx] = $tmp;
			$curIdx = $nextIdx;
		}
	}

?>

<rss version='2.0' xmlns:media='http://purl.org/dc/elements/1.1/' xmlns:dc='http://purl.org/dc/elements/1.1/'>

<!-- Init of titleArray and scrambleArray -->
<?php	
	echo "<script>\n";
	echo "titleArray=null;\n";
	echo "scrambleArray=null;\n";
	for($i=0; $i<$cells ; $i++)
	{
		echo "titleArray=pushBackStringArray(titleArray, \"$i\");\n";
		echo "scrambleArray=pushBackStringArray(scrambleArray, \"$scrambleArray[$i]\");\n";
	}
	echo "</script>\n";
?>

<!-- Exchange of 2 cells in scrambleArray and test if puzzle is solved -->
<move>
	if(nextIdx != curIdx)
	{
		tmpsrc = getStringArrayAt(scrambleArray,curIdx);
		tmpdst = getStringArrayAt(scrambleArray,nextIdx);
		tmpstr = null;
		tmpArray = null;
		solved = "true";
	
<?php
	for($i=0; $i<$cells ; $i++)
	{
		echo "if (\"$i\" == curIdx) {\n";
		echo "tmpArray=pushBackStringArray(tmpArray, tmpdst);\n";
		echo "} else if (\"$i\" == nextIdx){\n";
		echo "tmpArray=pushBackStringArray(tmpArray, tmpsrc);\n";
		echo "} else {\n";
		echo "tmpstr = getStringArrayAt(scrambleArray,$i);\n";
		echo "tmpArray=pushBackStringArray(tmpArray, tmpstr);\n";
		echo "}\n\n";
	}
?>
		scrambleArray = null;
<?php
	for($i=0; $i<$cells ; $i++)
	{
		echo "tmpstr = getStringArrayAt(tmpArray,$i);\n";
		echo "scrambleArray=pushBackStringArray(scrambleArray, tmpstr);\n";
		echo "if(tmpstr != $i) solved = \"false\";\n";
	}
?>
		curIdx = nextIdx;
	}
	
</move>

<!-- Init RSS vars -->
<onEnter>
	
	cells = <?= $cells ?>;
	rows = <?= $rows ?>;
	rowsM1 = minus(rows,1);
	curIdx = <?= $curIdx ?>;
	nextIdx = curIdx;
	low = minus(cells , rows);
	high = minus(cells , 1);
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
	itemOffsetXPC="0"
	itemOffsetYPC="0"
	itemGapXPC="0"
	itemGapYPC="0"
	>

<!-- onUserInput -->
<onUserInput>

	ret = "false";
	userInput = currentUserInput();

	if( solved == "false")
	{
		if( userInput == "R")
		{
			if (curIdx &gt;= rows)
			{
				nextIdx = minus(curIdx,rows);
				executeScript("move");
				redrawDisplay();
				ret = "true";
			}
		}

		if( userInput == "L")
		{
			if ((curIdx &gt;= low) &amp;&amp; (curIdx &lt; high))
				ret = "true";
			else if (curIdx &lt; low)
			{
				nextIdx = add(curIdx,rows);
				executeScript("move");
				redrawDisplay();
				ret = "true";
			}
		}

		if( userInput == "D")
		{
			modulo = Integer(curIdx%rows);
			if(modulo &gt; 0)
			{
				nextIdx = minus(curIdx,1);
				executeScript("move");
				redrawDisplay();
				ret = "true";
			}
		}

		if( userInput == "U")
		{
			modulo = Integer(curIdx%rows);
			if(modulo &lt; rowsM1)
			{
				nextIdx = add(curIdx,1);
				executeScript("move");
				redrawDisplay();
				ret = "true";
			}
		}
		
		if (( userInput == "ENTR" ) || (userInput == "DISPLAY"))
		{
			displaySolution = (displaySolution == "false") ? "true" : "false";
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
		if (displaySolution == "false")
			title = getStringArrayAt(scrambleArray,itemIdx);
		else
			title = getStringArrayAt(titleArray,itemIdx);
			
		image = "<?= $sTmpPath ?>" + title + ".jpg";
	</script>

	<image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
	<script>
		if ((itemIdx == curIdx) &amp;&amp; (displaySolution == "false") &amp;&amp; (solved == "false"))
			"";
		else
			image;
	</script>
	</image>
</itemDisplay>

</mediaDisplay>
<!-- mediaDisplay  END -->

<!-- item_template -->
<item_template>
	<displayTitle>
		<script>
			getStringArrayAt(titleArray,-1);
		</script>
	</displayTitle>
</item_template>

<!-- channel -->
<channel>
	<title>xPuzzle</title>
	<itemSize><script>cells;</script></itemSize>
</channel>

</rss>

