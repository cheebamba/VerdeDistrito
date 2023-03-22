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
				<!-- BEGIN: CATS_ROW -->
				<br>
				<div align="left"><table width="90%">
				<tr><td>{TEXT_DEL}</td><td width="30">{TEXT_ID}</td><td></td><td>{TEXT_TITLE}</td><td>{TEXT_ST}</td><td>{TEXT_ICO}</td><td>{TEXT_MINLEVEL}</td><td></td></tr>
				<form method="POST" action="admin.php?s=cats" name="cat">
				<tr><td>{CAT_DEL}</td><td width="40">ID: <b>{CAT_ID} {CAT_SUBID}</b></td><td></td><td>{CAT_TITLE}</td><td>{CAT_ST}</td><td>{CAT_ICO}</td><td>{CAT_MINLEVEL}</td><td>{CAT_SEND}</td></tr></table></div>
				</form>
				<div align="center"><table width="90%"><tr><td>{TEXT_DEL}</td><td>{TEXT_ID}</td><td>{TEXT_SUBID}</td><td>{TEXT_TITLE}</td><td>{TEXT_ST}</td><td>{TEXT_ICO}</td><td>{TEXT_MINLEVEL}</td><td>{TEXT_SEND}</td></tr>
				<!-- BEGIN: SUBCATS_ROW -->
				<form method="POST" action="admin.php?s=cats" name="cat">
				<tr><td>{SUBCAT_DEL}</td><td>{SUBCAT_ID}</td><td>{SUBCAT_SUBID}</td><td>{SUBCAT_TITLE}</td><td>{SUBCAT_ST}</td><td>{SUBCAT_ICO}</td><td>{SUBCAT_MINLEVEL}</td><td>{SUBCAT_SEND}</td></tr>
				</form>
				<!-- END: SUBCATS_ROW -->
				</table></div>
				<br>
				<hr>
				<!-- END: CATS_ROW -->
				<br><br>
				{NEW_ADD_TEXT}:<br>
				<center><b>{NEW_ACTION}</b></center>
				<div align="left"><table>
				<form method="POST" action="admin.php?s=cats" name="cat">
				<tr><td>{TEXT_ID}</td><td>{TEXT_SUBID}</td><td>{TEXT_TITLE}</td><td>{TEXT_ST}</td><td>{TEXT_ICO}</td><td>{TEXT_MINLEVEL}</td><td></td></tr>
				<tr><td>{NEW_ID}</td><td>{NEW_SUBID}</td><td>{NEW_TITLE}</td><td>{NEW_ST}</td><td>{NEW_ICO}</td><td>{NEW_MINLEVEL}</td><td>{NEW_SEND}</td></tr>
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