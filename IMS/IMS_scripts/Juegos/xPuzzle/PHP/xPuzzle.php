<?php
	echo "<?xml version='1.0' ?>\n";
	
	// Get parameters
	$sLang = $_GET["lang"];

	// Verify parameters
	if($sLang !== "fr") $sLang = "en";

	// Init paths and vars
	$sPath = realpath(dirname(__FILE__)).'/';
	$sHttpPath = str_replace("/tmp/usbmounts/","http://localhost/media/",$sPath);
	$sImagePath = $sPath.'images/';

	// Get size
	$xml = simplexml_load_file($sPath."xPuzzle.xml");
	$sSize = trim($xml->size);

	//Retrieve local version
	$xml = simplexml_load_file($sPath."version.xml");
	$sVersion = "VER ".trim($xml->version);

?>

<rss version='2.0' xmlns:media='http://purl.org/dc/elements/1.1/' xmlns:dc='http://purl.org/dc/elements/1.1/'>

<?php
	// Brows /images/ to find .jpg
	$itemSize = 0;

	echo "<script>\n";
	echo "titleArray=null;\n";
	echo "linkArray=null;\n";
	echo "imageArray=null;\n";

	$d = dir($sImagePath);
	while (false !== ($name = $d->read()))
	{
		if($name != '.' && $name != '..' && is_file($sImagePath.$name) && (stristr($name, '.jpg') !== FALSE))
		{
			$sLink = $sHttpPath."xPuzzle1.php?lang=$sLang&amp;image=$name";
			$sImage = $sImagePath.$name;
			
			echo "titleArray=pushBackStringArray(titleArray, \"$name\");\n";
			echo "linkArray=pushBackStringArray(linkArray, \"$sLink\");\n";
			echo "imageArray=pushBackStringArray(imageArray, \"$sImage\");\n";
			
			$itemSize += 1;
		}
	}
	$d->close();
	echo "</script>\n";
?>

<!-- Init of RSS vars -->
<onEnter>
	size = "<?= $sSize ?>";
	redrawDisplay();
</onEnter>

<onExit>
</onExit>

<onRefresh>
</onRefresh>

<mediaDisplay name=photoView
	bottomYPC="100"
	headerYPC = "0"
	sideTopHeightPC="0"
	sideBottomHeightPC="0"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"
	rowCount=2
	columnCount=3
	drawItemText="no"
	itemImageXPC="0"
	itemOffsetXPC="5"
	itemOffsetYPC="20"
	itemGapXPC="2"
	itemGapYPC="2"
	backgroundColor="0:0:0"
	idleImageXPC=45
	idleImageYPC=42
	idleImageWidthPC=10
	idleImageHeightPC=16
	sliding="no"

	>
	<idleImage> image/POPUP_LOADING_01.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_02.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_03.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_04.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_05.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_06.jpg </idleImage>

<!-- onUserInput -->
<onUserInput>

	ret = "false";
	userInput = currentUserInput();

	if( userInput == "1")
	{
		size = "3x4";
		showIdle();
		redrawDisplay();
		ret = "true";
	}

	if( userInput == "2")
	{
		size = "3x5";
		showIdle();
		redrawDisplay();
		ret = "true";
	}

	if( userInput == "3")
	{
		size = "4x6";
		showIdle();
		redrawDisplay();
		ret = "true";
	}

	if( userInput == "4")
	{
		size = "4x7";
		showIdle();
		redrawDisplay();
		ret = "true";
	}

	if( userInput == "ENTR")
	{
		url=getItemInfo(getFocusItemIndex(),"link") + "&amp;size=" + size;
		showIdle();
		jumpToLink("destination");
		ret = "true";
	}

	ret;
</onUserInput>

	<backgroundDisplay>
		<image redraw=no offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100><?= $sPath."background.jpg" ?></image>
	</backgroundDisplay>


	<text redraw=yes align=center offsetXPC=12 offsetYPC=89 widthPC=5 heightPC=5.4 fontSize=20 backgroundColor=0:0:0>3x4
		<foregroundColor>
			<script>
				if(size == "3x4")
					"255:0:0";
				else
					"255:255:255";
			</script>
		</foregroundColor>
	</text>


	<text redraw=yes align=center offsetXPC=30 offsetYPC=89 widthPC=5 heightPC=5.4 fontSize=20 backgroundColor=0:0:0>3x5
		<foregroundColor>
			<script>
				if(size == "3x5")
					"255:0:0";
				else
					"255:255:255";
			</script>
		</foregroundColor>
	</text>


	<text redraw=yes align=center offsetXPC=48 offsetYPC=89 widthPC=5 heightPC=5.4 fontSize=20 backgroundColor=0:0:0>4x6
		<foregroundColor>
			<script>
				if(size == "4x6")
					"255:0:0";
				else
					"255:255:255";
			</script>
		</foregroundColor>
	</text>


	<text redraw=yes align=center offsetXPC=65 offsetYPC=89 widthPC=5 heightPC=5.4 fontSize=20 backgroundColor=0:0:0>4x7
		<foregroundColor>
			<script>
				if(size == "4x7")
					"255:0:0";
				else
					"255:255:255";
			</script>
		</foregroundColor>
	</text>

	<text redraw=yes align=left offsetXPC=83 offsetYPC=89 widthPC=10 heightPC=6 fontSize=16 backgroundColor=0:0:0 foregroundColor=255:255:255>
		<?= $sVersion ?>
	</text>


</mediaDisplay>

<destination>
	<link>
	<script>url;</script>
	</link>
</destination>

<item_template>
	<displayTitle><script>getStringArrayAt(titleArray,-1);</script></displayTitle>
	<media:thumbnail><script>getStringArrayAt(imageArray,-1);</script></media:thumbnail>
	<link><script>getStringArrayAt(linkArray,-1);</script></link>
</item_template>

<!-- channel -->
<channel>
	<title>xPuzzle</title>
	<itemSize><?= $itemSize ?></itemSize>
</channel>

</rss>

