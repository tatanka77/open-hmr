<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:media="http://search.yahoo.com/mrss/"
 exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
  <xsl:apply-templates select="//div[@class='gallery']//ul//li"/>
</xsl:template>

<xsl:template match="li">
 <xsl:variable name="img" select="a[1]/span[1]/img" />
 <xsl:variable name="title" select="$img/@alt" />
 <xsl:variable name="link" select="concat('http://music.ivi.ru', a[1]/@href)" />
   <item>
      <title><xsl:value-of select="$title" /></title>
      <link><xsl:value-of select="$link" /></link>
      <description></description>
      <source url="http://music.ivi.ru/">misic.ivi.ru/</source>
      <image url="{$img/@src}" width="" height=""/>
   </item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
