<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//ul[@class='page1']/li/div|//ul[@class='page2']/li/div|//ul[@class='page3']/li/div|//ul[@class='page4']/li/div"/>
</xsl:template>

<xsl:template match="div">
  <xsl:variable name="img" select="a[1]/img" />
  <xsl:variable name="title" select="$img/@alt" />
  <xsl:variable name="link" select="concat('app/antena3/salon,index2,http://www.antena3.com', a[1]/@href)" />
		<item>
			<title><xsl:value-of select="$title" /></title>
			<link><script>translate_base_url+"<xsl:value-of select="$link" />";</script></link>
			<media:thumbnail width="169" height="109">
					<xsl:attribute name="url">http://www.antena3.com<xsl:value-of select="$img/@src" /></xsl:attribute>
			</media:thumbnail>
		</item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
