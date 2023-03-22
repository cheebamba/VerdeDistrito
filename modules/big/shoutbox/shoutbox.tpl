<!-- BEGIN: MAIN -->
<tr>
	<td>
		<table border="0" width="551" cellspacing="0" cellpadding="0">
			<tr>
				<td width="6">&nbsp;</td>
				<td width="536">
				<div align="center"><table width="95%"><tr><td width="50%"><br><font class="text1">{SHOUT_TEXT_SHOUTS}:</font><hr></td><td width="50%"><br><font class="text1">{SHOUT_TEXT_NEW}:</font><hr></td></tr></table></div>
				<div align="center"><table width="90%" cellspacing="5">
				<tr>
				<td width="50%">
				<div align="center"><table width="90%"><tr><td>
				<!-- BEGIN: SHOUT_ROW -->
				{SHOUT_ROW_OWNER}<b>:</b> {SHOUT_ROW_TEXT}
				<!-- BEGIN: ACTION -->
				{SHOUT_ACTION_LINKS}
				<!-- END: ACTION -->
				<br><img src="templates/{PHP.defskin}/images/spacer.gif" width="4"><br><img border="0" src="templates/{PHP.defskin}/images/hr_shout.jpg"><br><img src="templates/{PHP.defskin}/images/spacer.gif" width="4"><br>
				<!-- END: SHOUT_ROW -->
				<br><br>
				<center>{SHOUT_PAGES}</center>
				</td></tr></table></div>
				</td>
				<td width="50%" align="center" valign="top">
				<center><br>
				<!-- BEGIN: SHOUT_EDIT -->
				{SHOUT_EDIT_FORM}
				{SHOUT_EDIT_OWNER_TEXT}: {SHOUT_EDIT_OWNER}<br>
				{SHOUT_EDIT_SMILES}<br>
				{SHOUT_EDIT_TEXT}<br>
				{SHOUT_EDIT_SEND}
				</form>
				<!-- END: SHOUT_EDIT -->
				<form name="shoutbox" method="POST" action="plugin.php?plug=shoutbox">
				{SHOUT_NEW_SMILES}<br>
				{SHOUT_NEW_TEXT}<br>
				{SHOUT_NEW_SEND}
				</form>
				</center>
				</td>
				</tr>
				</table>
				</div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<!-- END: MAIN -->