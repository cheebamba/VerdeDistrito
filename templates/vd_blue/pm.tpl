<!-- BEGIN: MAIN -->
	<tr>
		<td>
			<table border="0" width="551" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536"><font class="text1"><div id="big"><center><br>
					{PM_LINKS}
					</center>
					</font>
					</div>
					<hr><br>
					</td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<!-- BEGIN: ARCHIVES -->
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536">
					<div align="center"><table width="350">
					<tr><td align="left" width="200">{PM_TEXT_TITLE}</td><td align="left" width="50">{PM_TEXT_FROM}</td><td align="left" width="100">{PM_TEXT_DATE}</td></tr>
					</table></div>
					<div align="center"><table width="350"><tr><td><hr></td></tr></table></div>
					<!-- BEGIN: PM_ROWS -->
					<div align="center"><table width="350">
					<tr><td align="left" width="200"><div id="pm">{PM_ROW_TITLE}</div></td><td align="left" width="50">{PM_ROW_FROM}</td><td align="left" width="100">{PM_ROW_DATE}</td></tr>
					<tr><td>{PM_ROW_ACTIONS}</td><td></td><td></td></tr>
					</table></div>
					<div align="center"><table width="350"><tr><td><hr></td></tr></table></div>
					<!-- END: PM_ROWS -->
					<center>
					{PM_NONEPMS}</center></td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END: ARCHIVES -->
	<!-- BEGIN: SEND_BOX -->
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536">
					<div align="center"><table width="350">
					<tr><td align="left" width="200">{PM_TEXT_TITLE}</td><td align="left" width="50">{PM_TEXT_TO}</td><td align="left" width="100">{PM_TEXT_DATE}</td></tr>
					</table></div>
					<div align="center"><table width="350"><tr><td><hr></td></tr></table></div>
					<!-- BEGIN: PM_ROWS -->
					<div align="center"><table width="350">
					<tr><td align="left" width="200"><div id="pm">{PM_ROW_TITLE}</div></td><td align="left" width="50">{PM_ROW_TO}</td><td align="left" width="100">{PM_ROW_DATE}</td></tr>
					<tr><td>{PM_ROW_ACTIONS}</td><td></td><td></td></tr>
					</table></div>
					<div align="center"><table width="350"><tr><td><hr></td></tr></table></div>
					<!-- END: PM_ROWS -->
					<center>
					{PM_NONEPMS}</center></td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END: SEND_BOX -->
	<!-- BEGIN: SEND_ERROR -->
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536"><center><font class="text1">{PM_ERROR}</font></center></td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END: SEND_ERROR -->
	<!-- BEGIN: NEW_PM -->
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536">
					<form method="POST" action="pm.php?s=send">
					<div align="center"><table width="75%">
					<tr><td width="30%" valign="top">{PM_TEXT_TO}:</td><td>{PM_FORM_TO}<br>{PM_TEXT_TO2}</td></tr>
					<tr><td>{PM_TEXT_TITLE}:</td><td>{PM_FORM_TITLE}</td></tr>
					<tr><td valign="top">{PM_TEXT_TEXT}:</td><td>{PM_FORM_TEXT}</td></tr>
					<tr><td></td><td>{PM_FORM_SEND}</td></tr>
					</table>
					</div>
					</form>
					</td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END: NEW_PM -->
	<!-- BEGIN: VIEW_PM -->
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536">
					<div align="center">
					<table bgcolor="#F0F0F0" width="70%">
					<tr><td><font class="text1">{PM_TITLE}</font><br><font class="text2">{PM_DATE}</font></td><td align="right">{PM_TEXT_WROTEBY}: {PM_FROM}<br>{PM_TEXT_TO}: {PM_TO}</td></tr>
					</table>	
					<hr width="70%">
					<table width="70%">
					<tr><td>{PM_TEXT}</td></tr>
					</table>
					<hr width="70%">
					<table width="70%">
					<tr><td>{PM_ACTIONS}</td></tr>
					</table>
					</div>
					</td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END: VIEW_PM -->
	<!-- BEGIN: UNREAD_BOX -->
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="6">&nbsp;</td>
					<td width="536">
					<div align="center"><table width="350">
					<tr><td align="left" width="200">{PM_TEXT_TITLE}</td><td align="left" width="50">{PM_TEXT_FROM}</td><td align="left" width="100">{PM_TEXT_DATE}</td></tr>
					</table></div>
					<div align="center"><table width="350"><tr><td><hr></td></tr></table></div>
					<!-- BEGIN: PM_ROWS -->
					<div align="center"><table width="350">
					<tr><td align="left" width="200"><div id="pm">{PM_ROW_TITLE}</div></td><td align="left" width="50">{PM_ROW_FROM}</td><td align="left" width="100">{PM_ROW_DATE}</td></tr>
					<tr><td>{PM_ROW_ACTIONS}</td><td></td><td></td></tr>
					</table></div>
					<div align="center"><table width="350"><tr><td><hr></td></tr></table></div>
					<!-- END: PM_ROWS -->
					<center>
					{PM_NONEPMS}</center></td>
					<td width="9">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END: UNREAD_BOX -->
<!-- END: MAIN -->