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
				<!-- BEGIN: CONFIG_ROW -->
				<form method="POST" action="admin.php?s=config">
				{CONFIG_CAT}.{CONFIG_NAME}<br>
				{CONFIG_TEXT} : {CONFIG_VALUE} {CONFIG_SEND}</form><br><hr><br>
				<!-- END: CONFIG_ROW -->
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<!-- END: MAIN -->