<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//video"/>
</xsl:template>

<xsl:template match="video">
  <xsl:variable name="link" select="urlHD" />
  <xsl:variable name="pre" select= "substring-before($link, 'mp4:')" />
  <xsl:variable name="post" select= "substring-after($link, 'mp4:')" />
		<item>
			<link><xsl:value-of select="$pre" /><xsl:value-of select="$post" /></link>
		</item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
