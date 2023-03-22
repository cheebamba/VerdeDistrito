<!-- BEGIN: MAIN -->
<tr>
	<td>
		<table border="0" width="551" cellspacing="0" cellpadding="0">
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536"><div align="center"><table width="95%"><tr><td>
				<div align="center"><table width="90%"><tr>
				{ADMIN_MENU}
				</tr></table></div>
				<hr>
				<!-- BEGIN: CAT_ROW -->
				<br>
				<div align="left"><table width="50%">
				<tr><td>{TEXT_DEL}</td><td width="30">{TEXT_ID}</td><td>{TEXT_TITLE}</td><td>{TEXT_MINLEVEL}</td><td></td></tr>
				<form method="POST" action="admin.php?s=forum" name="cat">
				<tr><td>{CAT_DEL}</td><td width="40">{CAT_SUBID}</b></td><td>{CAT_TITLE}</td><td>{CAT_MINLEVEL}</td><td>{CAT_SEND}</td></tr></table></div>
				</form>
				<div align="left"><table width="70%"><tr><td width="10%"></td><td>{TEXT_DEL}</td><td>{TEXT_ID}</td><td>{TEXT_SUBID}</td><td>{TEXT_LOCKED}</td><td>{TEXT_TITLE}</td><td>{TEXT_DES}</td><td>{TEXT_MINLEVEL}</td><td></td></tr>
				<!-- BEGIN: SUB_ROW -->
				<form method="POST" action="admin.php?s=forum" name="cat">
				<tr><td width="10%"></td><td valign="top">{SUB_DEL}</td><td valign="top">{SUB_CATID}</td><td valign="top">{SUB_SUBID}</td><td valign="top">{SUB_LOCKED}</td><td valign="top">{SUB_TITLE}</td><td valign="top">{SUB_DES}</td><td valign="top">{SUB_MINLEVEL}</td><td valign="top">{SUB_SEND}</td></tr>
				</form>
				<!-- END: SUB_ROW -->
				</table></div>
				<br>
				<hr>
				<!-- END: CAT_ROW -->
				<br><br>
				{NEWC_ADD_TEXT}:<br>
				<div align="left"><table>
				<form method="POST" action="admin.php?s=forum" name="cat">
				<tr><td>{TEXT_SUBID}</td><td>{TEXT_TITLE}</td><td>{TEXT_MINLEVEL}</td><td></td></tr>
				<tr><td>{NEWC_SUBID}</td><td>{NEWC_TITLE}</td><td>{NEWC_MINLEVEL}</td><td>{NEWC_SEND}</td></tr>
				</form>
				</table></div>
				<br><hr><br>
				<br>{NEWS_ADD_TEXT}:<br>
				<div align="left"><table>
				<form method="POST" action="admin.php?s=forum" name="cat">
				<tr><td>{TEXT_CATID}</td><td>{TEXT_SUBID}</td><td>{TEXT_TITLE}</td><td>{TEXT_DES}</td><td>{TEXT_MINLEVEL}</td><td></td></tr>
				<tr><td valign="top">{NEWS_CATID}</td><td valign="top">{NEWS_SUBID}</td><td valign="top">{NEWS_TITLE}</td><td valign="top">{NEWS_DES}</td><td valign="top">{NEWS_MINLEVEL}</td><td valign="top">{NEWS_SEND}</td></tr>
				</form>
				</table></div>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<!-- END: MAIN -->