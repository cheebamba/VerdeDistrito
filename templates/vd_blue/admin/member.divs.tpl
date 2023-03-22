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
				<br>
				<div align="left"><table width="70%">
				<tr><td>{TEXT_DEL}</td><td width="30">{TEXT_SUBID}</td><td></td><td>{TEXT_NAME}</td><td>{TEXT_ST}</td><td>{TEXT_ICO}</td><td>{TEXT_MINLEVEL}</td><td></td><td align="right">{TEXT_MEMBERS}</td></tr>
				<!-- BEGIN: DIV_ROW -->
				<form method="POST" action="admin.php?s=divs" name="div">
				<tr><td>{DIV_DEL}</td><td width="40">{DIV_SUBID}</b></td><td></td><td>{DIV_NAME}</td><td>{DIV_ST}</td><td>{DIV_ICO}</td><td>{DIV_MINLEVEL}</td><td>{DIV_SEND}</td><td align="right">{DIV_MEMBERS}</td>
				</form>
				<!-- END: DIV_ROW -->
				</tr></table></div>
				<br><hr>
				<br><br>
				{NEW_ADD_TEXT}:<br>
				<center><b>{NEW_ACTION}</b></center>
				<div align="left"><table>
				<form method="POST" action="admin.php?s=divs" name="ndiv">
				<tr><td>{TEXT_SUBID}</td><td>{TEXT_NAME}</td><td>{TEXT_ST}</td><td></td></tr>
				<tr><td>{NEW_SUBID}</td><td>{NEW_NAME}</td><td>{NEW_ST}</td><td>{NEW_SEND}</td></tr>
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