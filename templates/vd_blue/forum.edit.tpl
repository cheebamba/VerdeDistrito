<!-- BEGIN: MAIN -->
<tr>
	<td>
		<div align="center"><table width="95%" border="0">
		<!-- BEGIN: TOPIC_ROW -->
			<tr> 
      			<td colspan="3"><br>{TOPIC_TIME}<br><br>
        		<b>{TOPIC_URL}</b>
      			</td>
    		</tr>
    		<tr> 
      			<td colspan="3" align="center">
    			<br><b>{TOPIC_TEXT_WRITE}</b>
    			{TOPIC_ERROR}
    			</td>
    		</tr>
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536"><div align="center"><table width="60%"><tr><td>
				
				<br>
				<form name="form" method="POST" action="forum.php?m=new">
				{TOPIC_TEXT_TOPIC}:<br>{TOPIC_FORM_TOPIC}<br>
				{TOPIC_TEXT_TEXT}:<br>
				<table><tr>
				<td colspan="2">
				{TOPIC_BBCBOX}
				</td>
				</tr><tr><td colspan="2">{TOPIC_FORM_TEXT}</td></tr>
				<tr><td colspan="2">{TOPIC_SMILES}</td></tr>
				<!-- BEGIN: ADMIN_ROW -->
				<tr>
				<td width="20%"  align="left">
				{ADMIN_TEXT_LOCKED}
				</td><td align="left">
				{ADMIN_LOCKED}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_TEXT_COMMON}
				</td><td align="left">
				{ADMIN_COMMON}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_TEXT_ADVERT}
				</td><td align="left">
				{ADMIN_ADVERT}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_TEXT_STICKED}
				</td><td align="left">
				{ADMIN_STICKED}
				</td>
				</tr>
				<!-- END: ADMIN_ROW -->
				</table><br>
				{TOPIC_FORM_SEND}
				</form>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		<!-- END: TOPIC_ROW -->
		<!-- BEGIN: TOPIC_EDIT -->
			<tr> 
      			<td colspan="3"><br>{TOPIC_TIME}<br><br>
        		<b>{TOPIC_URL}</b>
      			</td>
    		</tr>
    		<tr> 
      			<td colspan="3" align="center">
    			<br><b>{TOPIC_TEXT_WRITE}</b>
    			{TOPIC_ERROR}
    			</td>
    		</tr>
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536"><div align="center"><table width="60%"><tr><td>
				
				<br>
				<form name="form" method="POST" action="forum.php?m=edit">
				{TOPIC_TEXT_TOPIC}:<br>{TOPIC_FORM_TOPIC}<br>
				{TOPIC_TEXT_TEXT}:<br>
				<table><tr>
				<td colspan="2">
				{TOPIC_BBCBOX}
				</td>
				</tr><tr><td colspan="2">{TOPIC_FORM_TEXT}</td></tr>
				<tr><td colspan="2">{TOPIC_SMILES}</td></tr>
				<!-- BEGIN: ADMIN_ROW -->
				<tr>
				<td width="20%" align="left">
				{ADMIN_TEXT_LOCKED}
				</td><td align="left">
				{ADMIN_LOCKED}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_TEXT_COMMON}
				</td><td align="left">
				{ADMIN_COMMON}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_TEXT_ADVERT}
				</td><td align="left">
				{ADMIN_ADVERT}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_TEXT_STICKED}
				</td><td align="left">
				{ADMIN_STICKED}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_MOVETO_TEXT}
				</td><td align="left">
				{ADMIN_MOVETO}
				</td>
				</tr>
				<tr>
				<td align="left">
				{ADMIN_DELETE_TEXT}
				</td><td align="left">
				{ADMIN_DELETE}
				</td>
				</tr>
				<!-- END: ADMIN_ROW -->
				</table><br>
				{TOPIC_FORM_SEND}
				</form>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		<!-- END: TOPIC_EDIT -->
		<!-- BEGIN: POST_EDIT -->
			<tr> 
      			<td colspan="3"><br>{POST_TIME}<br><br>
        		<b>{POST_URL}</b>
      			</td>
    		</tr>
    		<tr> 
      			<td colspan="3" align="center">
    			<br><b>{POST_TEXT_WRITE}</b>
    			{POST_ERROR}
    			</td>
    		</tr>
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536"><div align="center"><table width="60%"><tr><td>
				
				<br>
				<form name="form" method="POST" action="forum.php?m=edit">
				{POST_TEXT_TEXT}:<br>
				<table><tr>
				<td colspan="2">
				{POST_BBCBOX}
				</td>
				</tr><tr><td colspan="2">{POST_FORM_TEXT}</td></tr>
				<tr><td colspan="2">{POST_SMILES}</td></tr>
				<!-- BEGIN: ADMIN_ROW -->
				<tr>
				<td width="20%" align="left">
				{ADMIN_DELETE_TEXT}
				</td><td align="left">
				{ADMIN_DELETE}
				</td>
				</tr>
				<!-- END: ADMIN_ROW -->
				</table><br>
				{POST_FORM_SEND}
				</form>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		<!-- END: POST_EDIT -->
		<!-- BEGIN: REPLY_ROW -->
			<tr> 
      			<td colspan="3"><br>{POST_TIME}<br><br>
        		<b>{POST_URL}</b>
      			</td>
    		</tr>
    		<tr> 
      			<td colspan="3" align="center">
    			<br><b>{POST_TEXT_WRITE}</b>{POST_ERROR}
    			</td>
    		</tr>
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536"><div align="center"><table width="60%"><tr><td>
				
				<br>
				<form name="form" method="POST" action="forum.php?m=reply">
				{POST_TEXT_TEXT}:<br>
				<table><tr>
				<td colspan="2">
				{POST_BBCBOX}
				</td>
				</tr><tr><td colspan="2">{POST_FORM_TEXT}</td></tr>
				<tr><td colspan="2">{POST_SMILES}</td></tr>
				</table><br>
				{POST_FORM_SEND}
				</form>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		<!-- END: REPLY_ROW -->
		</table>
	</td>
</tr>
<!-- END: MAIN -->