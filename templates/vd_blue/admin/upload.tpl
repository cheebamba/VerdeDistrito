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
				<center>
				<!-- BEGIN: UPLOAD_URL -->
				{UPLOAD_TEXT_URL}: {UPLOAD_FORM_URL}
				<!-- END: UPLOAD_URL -->
				<!-- BEGIN: UPLOAD_ROW -->
				<form method="POST" action="admin.php?s=upload" enctype="multipart/form-data">
				{UPLOAD_TEXT_FILE}: {UPLOAD_FORM_FILE}<br>
				{UPLOAD_FORM_SEND}
				</form>
				<!-- END: UPLOAD_ROW -->
				</center>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<!-- END: MAIN -->