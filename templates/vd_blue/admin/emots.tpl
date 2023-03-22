<!-- BEGIN: MAIN -->
<tr>
	<td>
		<table border="0" width="551" cellspacing="0" cellpadding="0">
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536"><div align="center"><table width="95%"><tr><td>
				<table><tr><td>
				{ADMIN_MENU}
				</td></tr></table>
				<hr><br>
				<table>
				<tr><td>{SMILE_TEXT_DEL}</td><td>{SMILE_TEXT_CODE}</td><td>{SMILE_TEXT_TEXT}</td><td>{SMILE_TEXT_URL}</td><td></td><td></td></tr>
				<!-- BEGIN: SMILES_ROW -->
				<form method="POST" action="admin.php?s=emots">
				<tr><td>{SMILE_FORM_DEL}</td><td>{SMILE_FORM_CODE}</td><td>{SMILE_FORM_TEXT}</td><td>{SMILE_FORM_URL}</td><td>{SMILE_FORM_IMG}</td><td>{SMILE_FORM_SEND}</td></tr>
				</form>
				<!-- END: SMILES_ROW -->
				</table>
				<br><hr><br>
				<b>{SMILE_TEXT_NEW}</b>
				<table>
				<tr><td>{SMILE_TEXT_CODE}</td><td>{SMILE_TEXT_TEXT}</td><td>{SMILE_TEXT_URL}</td><td></td></tr>
				<form method="POST" action="admin.php?s=emots">
				<tr><td>{SMILE_FORM_CODE}</td><td>{SMILE_FORM_TEXT}</td><td>{SMILE_FORM_URL}</td><td>{SMILE_FORM_SEND}</td></tr>
				</form>
				</table>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<!-- END: MAIN -->