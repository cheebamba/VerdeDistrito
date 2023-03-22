<!-- BEGIN: MAIN -->
<tr>
	<td>
	<div align="center"><table width="95%" border="0">
    <tr>
      <td><br>{CAT_TIME}<br><br>
        <b>{CAT_URL}</b></td>
    </tr>
  </table>
  <br>
  <table width="95%" border="0" cellspacing="0" cellpadding="0" bgcolor="#BDBDBD">
    <tr bgcolor="#EFF7FF"> 
      <td height="18" colspan="2" valign="top" bgcolor="#EFF7FF"> 
        <div align="center"><b><font color="#748AB1">{TEXT_FORUM}</font></b></div>
      </td>
      <td width="90"> 
        <div align="center"><b><font color="#748AB1">{TEXT_TOPICS}</font></b></div>
      </td>
      <td width="70"> 
        <div align="center"><b><font color="#748AB1">{TEXT_POSTS}</font></b></div>
      </td>
      <td width="281"> 
        <div align="center"><b><font color="#748AB1">{TEXT_LAST}</font></b></div>
      </td>
    </tr>
    <!-- BEGIN: CAT_ROW -->
    <tr bgcolor="#EEF1F4"> 
      <td colspan="5" height="20" valign="middle"> &nbsp;&nbsp;<b>{CAT_TITLE}</b></td>
    </tr>
    <!-- BEGIN: SUB_ROW -->
    <tr> 
      <td width="90" bgcolor="#F9FBFC"> 
        <div align="center">{SUB_ICO}</div>
      </td>
      <td width="416" bgcolor="#F9FBFC"> 
        <table width="95%" border="0" align="center">
          <tr> 
            <td><b><a href="forum.php?id={SUB_ID}">{SUB_TITLE}</a></b><br>
              {SUB_DES}<br>{SUB_TEXT_MODS}: {SUB_MODS}
              </td>
          </tr>
        </table>
      </td>
      <td width="90" bgcolor="#F4F6F8"> 
        <div align="center">{SUB_TCOUNT}</div>
      </td>
      <td width="70" bgcolor="#F4F6F8"> 
        <div align="center">{SUB_PCOUNT}</div>
      </td>
      <td width="281" bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="center"> 
          <table width="95%"  border="0">
            <tr> 
              <td align="center">{SUB_LKIND}{SUB_LDATE}{SUB_LOWNER}</td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <!-- END: SUB_ROW -->
    <!-- END: CAT_ROW -->
  </table>
  <br>
  <table width="95%" border="0" cellspacing="0" bgcolor="#BDBDBD">
    <tr bgcolor="#EFF7FF"> 
      <td valign="top" height="20" colspan="2"><b><font color="#748AB1">&nbsp;&nbsp;<b></b>{TEXT_WHOSHERE}</font></b></td>
    </tr>
    <tr> 
      <td rowspan="3" valign="middle" align="center" bgcolor="#F9FBFC" width="88"> 
        <div align="center"><img src="templates/vd_blue/icons/forum_users.gif" width="34" height="34"></div>
      </td>
      <td height="20" valign="top" width="858" bgcolor="#F4F6F8">{FORUM_STATS_1}<br>
      {FORUM_STATS_2}<br>
        {FORUM_STATS_3}</td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#F4F6F8">{FORUM_STATS_4}<br>
        {FORUM_STATS_5}</td>
    </tr>
  </table>
  <br>
</div>
<div align="center">
  <table width="95%" border="0">
    <tr>
      <td></td>
    </tr>
  </table>
  <table width="50%" border="0">
    <tr> 
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_new.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_NEW_POSTS}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_old.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_NONE_NEW}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_locked.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_FORUM_LOCKED}</div>
      </td>
    </tr>
  </table>
  </div>
</td>
</tr>
<!-- END: MAIN -->