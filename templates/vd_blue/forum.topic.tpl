<!-- BEGIN: MAIN -->
<tr>
	<td>
	<div align="center">
  <table width="95%" border="0">
    <tr> 
      <td colspan="2"><br>{TOPIC_TIME}<br>
      </td>
    </tr>
    <tr> 
      <td width="70%" height="23" valign="middle" align="left"> 
        <b>{TOPIC_URL}</b>
      </td>
      <td width="30%" valign="middle"><div align="right">{TOPIC_BUTTON_NEW}&nbsp;&nbsp;&nbsp;{TOPIC_BUTTON_REPLY}</div></td>
    </tr>
  </table>
  <table width="95%" border="0" cellspacing="0" cellpadding="0" bgcolor="#BDBDBD">
    <tr> 
      <td height="19" width="200" valign="top" bgcolor="#EFF7FF"> 
        <div align="center"><b><font color="#748AB1">{TOPIC_TEXT_AUTHOR}</font></b></div>
      </td>
      <td colspan="2" valign="top" bgcolor="#EFF7FF"> 
        <div align="center"><b><font color="#748AB1">{TOPIC_TEXT_MESSAGE}</font></b></div>
      </td>
    </tr>
    <!-- BEGIN: TOPIC_ROW -->
    <tr> 
      <td valign="top" bgcolor="#F9FBFC" rowspan="2"> 
        <table width="90%" border="0" align="center" height="80%">
          <tr> 
            <td valign="top"><a name="{TOPIC_ID}"></a><font color="#336699"><b>{TOPIC_OWNER_NICK}</b><br>
              {TOPIC_OWNER_LEVEL}</font><br>
              {TOPIC_OWNER_AVATAR}<br>
              {TOPIC_TEXT_REGDATE}: {TOPIC_OWNER_REGDATE}<br>
              {TOPIC_TEXT_POSTS}: {TOPIC_OWNER_POSTS}<br>
              {TOPIC_TEXT_FROM}: {TOPIC_OWNER_FROM}
            </td>
          </tr>
        </table>
      </td>
      <td valign="middle" height="18" width="611" bgcolor="#F4F6F8" align="center"> 
        <div align="left">&nbsp;{TOPIC_TEXT_SENT}: {TOPIC_SENT}</div>
      </td>
      <td width=200" valign="middle" bgcolor="#F4F6F8" align="right" valign="middle"> 
        {TOPIC_EDIT}{TOPIC_QUOTE} </td>
    </tr>
    <tr> 
      <td valign="top" colspan="2" bgcolor="#F4F6F8"> 
        <div align="center"> 
          <table width="98%" border="0">
            <tr> 
              <td valign="top">{TOPIC_TEXT}<br>
                  _________________<br><br>
                  {TOPIC_OWNER_SIGNATURE}<br>
                </p>
              </td>
            </tr>
          </table>
        </div>
        <p>&nbsp;</p>
      </td>
    </tr>
    <tr valign="middle"> 
      <td height="18" bgcolor="#F4F6F8"><b>{TOPIC_TOP}</b></td>
      <td colspan="2" bgcolor="#F4F6F8" valign="middle">&nbsp;{TOPIC_OWNER_PROFILE}&nbsp;{TOPIC_OWNER_PW}&nbsp;{TOPIC_OWNER_WWW}&nbsp;{TOPIC_OWNER_GG}</td>
    </tr>
    <tr> 
      <td height="18" colspan="3" valign="top" bgcolor="#EEF1F4"> 
        <div align="center"></div>
      </td>
    </tr>
    <!-- END: TOPIC_ROW -->
<!-- BEGIN: POST_ROW -->
    <tr> 
      <td valign="top" bgcolor="#F9FBFC" rowspan="2"> 
        <table width="90%" border="0" align="center" height="80%">
          <tr> 
            <td valign="top"><a name="{POST_ID}"></a><font color="#336699"><b>{POST_OWNER_NICK}</b><br>
              {POST_OWNER_LEVEL}</font><br>
              {POST_OWNER_AVATAR}<br>
              {POST_TEXT_REGDATE}: {POST_OWNER_REGDATE}<br>
              {POST_TEXT_POSTS}: {POST_OWNER_POSTS}<br>
              {POST_TEXT_FROM}: {POST_OWNER_FROM}
            </td>
          </tr>
        </table>
      </td>
      <td valign="middle" height="18" width="611" bgcolor="#F4F6F8" align="center"> 
        <div align="left">&nbsp;{POST_TEXT_SENT}: {POST_SENT}</div>
      </td>
      <td width="200" valign="middle" bgcolor="#F4F6F8" align="right" valign="middle"> 
      {POST_EDIT}{POST_QUOTE} </td>
    </tr>
    <tr> 
      <td valign="top" colspan="2" bgcolor="#F4F6F8"> 
        <div align="center"> 
          <table width="98%" border="0">
            <tr> 
              <td valign="top">{POST_TEXT}<br>
                  _________________<br><br>
                  {POST_OWNER_SIGNATURE}<br>
                </p>
              </td>
            </tr>
          </table>
        </div>
        <p>&nbsp;</p>
      </td>
    </tr>
    <tr valign="middle"> 
      <td height="18" bgcolor="#F4F6F8"><b>{TOPIC_TOP}</b></td>
      <td colspan="2" bgcolor="#F4F6F8" valign="middle">&nbsp;{POST_OWNER_PROFILE}&nbsp;{POST_OWNER_PW}&nbsp;{POST_OWNER_WWW}&nbsp;{POST_OWNER_GG}</td>
    </tr>
    <tr> 
      <td height="18" colspan="3" valign="top" bgcolor="#EEF1F4"> 
        <div align="center"></div>
      </td>
    </tr>
    <!-- END: POST_ROW -->
  </table>
  <table width="95%" border="0">
    <tr> 
      <td width="60%" height="23" valign="middle" align="left"> 
        <b>{TOPIC_URL}</b>
      </td>
      <td width="40%" height="27" valign="bottom"><div align="right">{TOPIC_BUTTON_NEW}&nbsp;&nbsp;&nbsp;{TOPIC_BUTTON_REPLY}</div></td>
    </tr>
    <tr> 
      <td width="103" height="23" valign="middle" align="center"> 
        <div align="left">{TOPIC_PAGES1}</div>
      </td>
      <td align="right" valign="middle">{TOPIC_PAGES2}</td>
      </tr>
  </table>
</div>
	</td>
</tr>
<!-- END: MAIN -->