<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//item"/>
</xsl:template>

<xsl:template match="item">
  <xsl:variable name="link" select="media:content/@url" />
  <xsl:variable name="title" select="title" />
		<item>
			<title><xsl:value-of select="$title" /></title>
			<link><xsl:value-of select="$link" /></link>
		</item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
