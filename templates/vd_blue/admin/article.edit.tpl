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
				<div align="center"><table width="80%"><tr><td>
				<center>{ARTICLE_TEXT_ACTION}</center>
				<form method="POST" action="admin.php?s=editart" name="profile" enctype="multipart/form-data">
				{ARTICLE_TEXT_TITLE}:<br>
				{ARTICLE_FORM_TITLE}<br>
				{ARTICLE_TEXT_CAT}:<br>
				{ARTICLE_FORM_CAT}<br>
				{ARTICLE_TEXT_AVATAR}:<br>
				{ARTICLE_FORM_AVATAR}<br>
				{ARTICLE_TEXT_DATE}:<br>
				{ARTICLE_FORM_DATE}<br>
				{ARTICLE_TEXT_TEXT}:<br>
				{ARTICLE_FORM_TEXT}<br>
				{ARTICLE_TEXT_DELETE}:<br>
				{ARTICLE_FORM_DELETE}<br>
				{ARTICLE_FORM_SEND}
				</form>
				<!-- BEGIN: ARTICLE_PAGES -->
				<br>
				<font class="text1">{TEXT_PAGE} {PAGE_NUM_PAGE}:</font>
				<br>
				<hr>
				<br>
				<form method="POST" action="admin.php?s=editart" name="profile" enctype="multipart/form-data">
				{PAGE_TEXT_PAGE}:<br>
				{PAGE_FORM_PAGE}<br>
				{PAGE_TEXT_TEXT}:<br>
				{PAGE_FORM_TEXT}<br>
				{PAGE_TEXT_DELETE}:<br>
				{PAGE_FORM_DELETE}<br>
				{PAGE_FORM_SEND}<br>
				</form>
				<!-- END: ARTICLE_PAGES -->
				<br>
				<font class="text1">{TEXT_ADDPAGE}:</font><br>
				<hr>
				<br>
				<form method="POST" action="admin.php?s=editart" name="profile" enctype="multipart/form-data">
				{ADD_TEXT_TEXT}:<br>
				{ADD_FORM_TEXT}<br>
				{ADD_FORM_SEND}<br>
				</form>
				</td></tr></table></div>
				</td></tr></table></div>
				</td>
				<td width="9">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<!-- END: MAIN -->