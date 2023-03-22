<!-- BEGIN: MAIN -->
<tr>
	<td>
	<div align="center"><table width="95%" border="0">
	<tr> 
      <td colspan="2"><br>{SUB_TIME}<br><br>
        {TEXT_MODS}: {SUB_MODS}<br>
        {TEXT_WHOSHERE}: <b>{SUB_WHOSHERE}</b>
      </td>
    </tr>
    <tr> 
      <td width="80%" height="23" valign="middle" align="left"> 
        <b>{SUB_URL}</b>
      </td>
      <td width="20%" valign="middle"><div align="right">{SUB_NEW_BUTTON}</div></td>
    </tr>
  </table>
  <br>
  <table width="95%" border="0" cellspacing="0" cellpadding="0" bgcolor="#BDBDBD">
    <tr bgcolor="#EFF7FF"> 
      <td height="19" colspan="2" valign="middle" bgcolor="#EFF7FF"> 
        <div align="center"><b><font color="#748AB1">{TEXT_TOPICS}</font></b></div>
      </td>
      <td width="98"> 
        <div align="center"><b><font color="#748AB1">{TEXT_REPLYS}</font></b></div>
      </td>
      <td width="92"> 
        <div align="center"><b><font color="#748AB1">{TEXT_VIEWS}</font></b></div>
      </td>
      <td width="107"> 
        <div align="center"><b><font color="#748AB1">{TEXT_AUTHOR}</font></b></div>
      </td>
      <td width="150"> 
        <div align="center"><b><font color="#748AB1">{TEXT_LASTP}</font></b></div>
      </td>
    </tr>
    <!-- BEGIN: ADVERT_B -->
    <tr bgcolor="#EEF1F4"> 
      <td colspan="6" height="18" valign="middle"> &nbsp;&nbsp;<b>{TEXT_ADVERT}</b></td>
    </tr>
    <!-- END: ADVERT_B -->
    <!-- BEGIN: ADVERT_ROW -->
    <tr> 
      <td width="38" bgcolor="#F9FBFC" height="36"> 
        <div align="center">{TOPIC_ICO}</div>
      </td>
      <td width="330" bgcolor="#F9FBFC"><b><a href="forum.php?t={TOPIC_ID}">{TOPIC_TITLE}</a></b></td>
      <td bgcolor="#F4F6F8"> 
        <div align="center">{TOPIC_POSTS}</div>
      </td>
      <td bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="center">{TOPIC_VIEWS}</div>
      </td>
      <td bgcolor="#F4F6F8"> 
        <div align="center"><b>{TOPIC_COWNER}</b></div>
      </td>
      <td bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="left"> 
          <table width="95%" border="0">
            <tr> 
              <td align="center">
              <!-- BEGIN: LP_ROW -->
              	{TOPIC_LDATE}<br>
              	<b>{TOPIC_LOWNER}</b>
                <!-- END: LP_ROW -->
                <!-- BEGIN: LP_EMPTY -->
                {TOPIC_LEMPTY}
                <!-- END: LP_EMPTY-->
                </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <!-- END: ADVERT_ROW -->
    <!-- BEGIN: ADVERT_E -->
    <tr bgcolor="#EEF1F4"> 
      <td height="18" colspan="6" valign="middle">&nbsp;&nbsp;<b>{TEXT_TOPICS}</b></td>
    </tr>
    <!-- END: ADVERT_E -->
    <!-- BEGIN: STICKED_ROW -->
    <tr> 
      <td width="38" height="18" bgcolor="#F9FBFC"> 
        <div align="center">{TOPIC_ICO}</div>
      </td>
      <td bgcolor="#F9FBFC"><b><a href="forum.php?t={TOPIC_ID}">{TOPIC_TITLE}</a></b></td>
      <td bgcolor="#F4F6F8"> 
        <div align="center">{TOPIC_POSTS}</div>
      </td>
      <td bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="center">{TOPIC_VIEWS}</div>
      </td>
      <td bgcolor="#F4F6F8"> 
        <div align="center"><font color="#4A6BA5"><b>{TOPIC_COWNER}</b></font></div>
      </td>
      <td bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="left"> 
          <table width="95%" border="0">
            <tr> 
              <td align="center">
              	<!-- BEGIN: LP_ROW -->
              	{TOPIC_LDATE}<br>
              	<b>{TOPIC_LOWNER}</b>
                <!-- END: LP_ROW -->
                <!-- BEGIN: LP_EMPTY -->
                {TOPIC_LEMPTY}
                <!-- END: LP_EMPTY-->
                </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <!-- END: STICKED_ROW -->
    <!-- BEGIN: TOPIC_EMPTY -->
    <tr> 
      <td height="18" colspan="6" bgcolor="#F9FBFC"> 
      	<center>{TOPIC_EMPTY}</center>
      </td>
    </tr>
    <!-- END: TOPIC_EMPTY -->
    <!-- BEGIN: TOPIC_ROW -->
    <tr> 
      <td width="38" height="18" bgcolor="#F9FBFC"> 
        <div align="center">{TOPIC_ICO}</div>
      </td>
      <td bgcolor="#F9FBFC" style="width: 240px"><b><a href="forum.php?t={TOPIC_ID}">{TOPIC_TITLE}</a></b></td>
      <td bgcolor="#F4F6F8"> 
        <div align="center">{TOPIC_POSTS}</div>
      </td>
      <td bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="center">{TOPIC_VIEWS}</div>
      </td>
      <td bgcolor="#F4F6F8"> 
        <div align="center"><font color="#4A6BA5"><b>{TOPIC_COWNER}</b></font></div>
      </td>
      <td bgcolor="#F4F6F8" valign="middle" align="center"> 
        <div align="left"> 
          <table width="95%" border="0">
            <tr> 
              <td align="center">
              	<!-- BEGIN: LP_ROW -->
              	{TOPIC_LDATE}<br>
              	<b>{TOPIC_LOWNER}</b>
                <!-- END: LP_ROW -->
                <!-- BEGIN: LP_EMPTY -->
                {TOPIC_LEMPTY}
                <!-- END: LP_EMPTY-->
                </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <!-- END: TOPIC_ROW -->
  </table>
  <br>
  <table width="95%" border="0">
    <tr> 
      <td width="80%" height="23" valign="middle" align="left"> 
        <b>{SUB_URL}</b>
      </td>
      <td width="20%" valign="middle"><div align="right">{SUB_NEW_BUTTON}</div></td>
    </tr>
    <tr> 
      <td width="103" height="23" valign="middle" align="center"> 
        <div align="left">{SUB_PAGES1}</div>
      </td>
      <td valign="middle">{SUB_PAGES2}</td>
      </tr>
	</table>
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
        <div align="center"><img src="templates/vd_blue/icons/forum_topic_new.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_TOPIC_NEW}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_sticked_new.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_STICKED_NEW}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_advert_new.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_ADVERT_NEW}</div>
      </td>
    </tr>
    <tr> 
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_topic_old.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_TOPIC_OLD}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_sticked_old.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_STICKED_OLD}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_advert_old.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_ADVERT_OLD}</div>
      </td>
    </tr>
    <tr> 
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_topic_locked.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_TOPIC_LOCKED}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_sticked_locked.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_STICKED_LOCKED}</div>
      </td>
      <td> 
        <div align="center"><img src="templates/vd_blue/icons/forum_advert_locked.gif" width="34" height="34"></div>
      </td>
      <td> 
        <div align="center">{TEXT_ADVERT_LOCKED}</div>
      </td>
    </tr>
  </table>
  </div>
</td>
</tr>
<!-- END: MAIN -->