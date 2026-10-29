<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="UTF-8" indent="yes"/>

<xsl:template match="/feed">
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>CampusEvents XML feed</title>
  <link rel="stylesheet" href="{@base}css/style.css"/>
</head>
<body>
  <header class="site-header">
    <div class="wrap header-row">
      <a class="brand" href="{@base}"><span class="brand-mark">CE</span><span class="brand-text"><strong>CampusEvents</strong><small>XML feed (XSLT view)</small></span></a>
      <nav class="main-nav" style="display:flex"><a href="{@base}events">Back to events</a></nav>
    </div>
  </header>
  <main>
    <section class="page-head"><div class="wrap">
      <h1>Event feed</h1>
      <p class="muted">This page is raw XML transformed in your browser with an XSL stylesheet. View source to see the XML.</p>
    </div></section>
    <section class="section tight"><div class="wrap">
      <div class="card" style="overflow-x:auto">
        <table class="table">
          <thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Time</th><th>Venue</th><th>Seats left</th><th>Status</th></tr></thead>
          <tbody>
            <xsl:for-each select="event">
              <tr>
                <td><a href="{@url}"><xsl:value-of select="title"/></a></td>
                <td><xsl:value-of select="category"/></td>
                <td><xsl:value-of select="date"/></td>
                <td><xsl:value-of select="time"/></td>
                <td><xsl:value-of select="venue"/></td>
                <td><xsl:value-of select="seats_left"/></td>
                <td><xsl:value-of select="@status"/></td>
              </tr>
            </xsl:for-each>
          </tbody>
        </table>
      </div>
    </div></section>
  </main>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
