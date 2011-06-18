<?php
	echo "<?xml version='1.0' ?>\n";
	
	// Get parameters
	$sLang = $_GET["lang"];

	// Verify parameters
	if($sLang !== "fr") $sLang = "en";

	// Init paths and vars
	$sPath = realpath(dirname(__FILE__)).'/';
	$sHttpPath = str_replace("/tmp/usbmounts/","http://localhost/media/",$sPath);

	//Retrieve local version
	$xml = simplexml_load_file($sPath."version.xml");
	$sVersion = "VER ".trim($xml->version);

?>

<rss version='2.0' xmlns:media='http://purl.org/dc/elements/1.1/' xmlns:dc='http://purl.org/dc/elements/1.1/'>

<!-- Init of RSS vars -->
<onEnter>
	textIdx = 0;
	nbText = 6;

	xSudoku = "<?= $sPath ?>" + "xSudoku.xml";
	dlok = loadXMLFile(xSudoku);
	if (dlok != null)
	{
		text0 = getXMLText("settings","<?= $sLang ?>","text0",0);
		text1 = getXMLText("settings","<?= $sLang ?>","text1",0);
		text2 = getXMLText("settings","<?= $sLang ?>","text2",0);
		text3 = getXMLText("settings","<?= $sLang ?>","text3",0);
		text4 = getXMLText("settings","<?= $sLang ?>","text4",0);
		text5 = getXMLText("settings","<?= $sLang ?>","text5",0);
	}
	else
	{
		text0 = "text0";
		text1 = "text1";
		text2 = "text2";
		text3 = "text3";
		text4 = "text4";
		text5 = "text5";
	}

	setRefreshTime(5000);
	redrawDisplay();
</onEnter>

<onExit>
	setRefreshTime(-1);
</onExit>

<onRefresh>
	textIdx = add(textIdx,1);
	if (textIdx &gt;= nbText) textIdx = 0;
	redrawDisplay();
</onRefresh>

<mediaDisplay name=photoView
	bottomYPC="100"
	headerYPC = "0"
	sideTopHeightPC="0"
	sideBottomHeightPC="0"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"
	rowCount=1
	columnCount=1
	backgroundColor="0:0:0"
	idleImageXPC=45
	idleImageYPC=42
	idleImageWidthPC=10
	idleImageHeightPC=16
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
		setRefreshTime(-1);
		url = sHttpPath + "xSudoku1.php?level=1";
		showIdle();
		jumpToLink("destination");
		ret = "true";
	}

	if( userInput == "2")
	{
		setRefreshTime(-1);
		url = sHttpPath + "xSudoku1.php?level=2";
		showIdle();
		jumpToLink("destination");
		ret = "true";
	}

	if( userInput == "3")
	{
		setRefreshTime(-1);
		url = sHttpPath + "xSudoku1.php?level=3";
		showIdle();
		jumpToLink("destination");
		ret = "true";
	}

	if( userInput == "4")
	{
		setRefreshTime(-1);
		url = sHttpPath + "xSudoku1.php?level=4";
		showIdle();
		jumpToLink("destination");
		ret = "true";
	}
	ret;
</onUserInput>

	<image redraw=no offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100><?= $sPath."background.jpg" ?></image>

	<text redraw=yes align=center lines=4 offsetXPC=16 offsetYPC=35 widthPC=37 heightPC=30 fontSize=24 backgroundColor=30:30:30 foregroundColor=150:200:150>
		<script>
			if(textIdx == 0) text0;
			else if(textIdx == 1) text1;
			else if(textIdx == 2) text2;
			else if(textIdx == 3) text3;
			else if(textIdx == 4) text4;
			else if(textIdx == 5) text5;
			else "";
		</script>
	</text>


	<text redraw=yes align=left offsetXPC=16 offsetYPC=67 widthPC=5 heightPC=6 fontSize=16 backgroundColor=30:30:30 foregroundColor=255:255:255>
		<script>add(textIdx,1) + " / 6";</script>
	</text>

	<text redraw=yes align=center offsetXPC=75 offsetYPC=89 widthPC=10 heightPC=6 fontSize=16 backgroundColor=36:36:36 foregroundColor=200:200:200>
		<?= $sVersion ?>
	</text>


</mediaDisplay>

<destination>
	<link>
	<script>url;</script>
	</link>
</destination>

<!-- channel -->
<channel>
	<title>xSudoku</title>
</channel>

</rss>

