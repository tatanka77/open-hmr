<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
<data>
    <xsl:apply-templates select="//div[@class='md-item']"/>
</data>
</xsl:template>

<xsl:template match="div">
  <xsl:variable name="img" select="div[1]/div/a/img" />
  <xsl:variable name="title" select="div[1]/div/a/@title" />
  <xsl:variable name="link" select="concat('http://www.rtvv.es', div[1]/div/a/@href)" />
		<video>
			<title><xsl:value-of select="$title" /></title>
			<url><xsl:value-of select="$link" /></url>
			<image>http://www.rtvv.es<xsl:value-of select="$img/@src" /></image>
		</video>
</xsl:template>

<xsl:template match="* | @* | node()"/>
</xsl:stylesheet>
