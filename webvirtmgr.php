<div style="width: 49%; float:left">
	<div id="title">
		<span class="left"><img src="/plugins/webGui/icons/default.png" class="icon" width="16" height="16">Status&#32;
			<?if ($webvirtmgr_installed=="yes"):?>
				<?if ($webvirtmgr_running=="yes"):?>
					<span class="green"><b>RUNNING</b></span>
					<span style="font-size:12px;"> with version: <b><?=$webvirtmgr_curversion?></b></span>
				<?else:?>
					<span class="red"><b>STOPPED</b></span>
				<?endif;?>
			<?else:?>
				<span class="red"><b>NOT INSTALLED</b></span>
			<?endif;?>  
		</span>
	</div>  
	<?if ($webvirtmgr_installed=="yes"):?>
		<?if ($webvirtmgr_running=="yes"):?>
			<div style="position:relative;float:left;width:50%;text-align:right; margin-bottom:24px">
				<form name="webvirtmgr_start_stop" method="POST" action="/plugins/webGui/exec.php" target="progressFrame">
					<input type="hidden" name="command" value="/etc/rc.d/rc.webvirtmgr stop  ">
					<input type="submit" value="Stop">
				</form>
			</div>
			<div style="position:relative;float:left;width:50%;margin-bottom:24px">
				<form name="webvirtmgr_restart" method="POST" action="/plugins/webGui/exec.php" target="progressFrame">
					<input type="hidden" name="command" value="/etc/rc.d/rc.webvirtmgr restart  ">
					<input type="submit" value="Restart">
				</form>
			</div>
		<?else:?>
			<div style="position:relative;float:left;width:100%;text-align:center;margin-bottom:24px">
				<form name="webvirtmgr_start" method="POST" action="/plugins/webGui/exec.php" target="progressFrame">
					<input type="hidden" name="command" value="/etc/rc.d/rc.webvirtmgr buttonstart  ">
					<input type="submit" value="Start">
				</form>
			</div>
		<?endif;?>
	<?else:?>
		<div style="position:relative;float:left;width:100%;text-align:center;margin-bottom:24px">
			<form name="webvirtmgr_install" method="POST" action="/plugins/webGui/exec.php" target="progressFrame">
				<input type="hidden" name="command" value="/etc/rc.d/rc.webvirtmgr install  ">          
				<input type="submit" value="Install">
			</form>
		</div>
	<?endif;?>
	<div id="title">
		<span class="left"><img src="/plugins/webGui/icons/default.png" class="icon" width="16" height="16">Information&#32;</span>
	</div>
	<? if ($webvirtmgr_installed=="yes"): ?>  
		<? if ($webvirtmgr_gitstatus=="update"): ?>  
			<p style="color:DarkOrange;margin-left:10px;margin-right:10px;"><?=$webvirtmgr_gitmsg?></p>
			<div style="position:relative;float:left;width:100%;text-align:center;margin-bottom:24px">
				<form name="webvirtmgr_update" method="POST" action="/plugins/webGui/exec.php" target="progressFrame">
					<input type="hidden" name="command" value="/etc/rc.d/rc.webvirtmgr update <?=$webvirtmgr_updatestatus?>">          
					<input type="submit" value="Update">
				</form>
			</div>
		<?else:?>
			<p style="color:green;margin-left:10px;margin-right:10px;">Web Virtual Manager is up to date.</p>
		<? endif; ?>
		<?=$webvirtmgr_storagesize?>
		<?=$webvirtmgr_datacheck?>
	<? endif; ?>
</div>
<div style="width: 49%; float:right">
	<div id="title">
		<span class="left"><img src="/plugins/webGui/icons/settings.png" class="icon" width="16" height="16">Configuration&#32;</span>
	</div>
	<form name="webvirtmgr_settings" method="POST" action="/update.htm" target="progressFrame">
		<input type="hidden" name="cmd" value="/etc/rc.d/rc.webvirtmgr">
		<table class="settings">
			<tr>
				<td>Enable WebVirtMgr:
					<input type="checkbox" name="enable" <?=($webvirtmgr_service=="enable")?"checked=\"checked\"":"";?> onChange="checkENABLE(this.form);">
					<input type="hidden" name="arg1" value="<?=$webvirtmgr_service;?>">     
				</td>
			</tr>
			<tr>
				<td>Install directory:</td>
				<td><input type="text" name="arg2" maxlength="60" value="<?=$webvirtmgr_installdir;?>" placeholder="ie. /mnt/cache/appdata for persistent data"></td>
			</tr>
			<tr>
				<td>Port:</td>
				<td><input type="text" name="arg3" maxlength="40" value="<?=$webvirtmgr_port;?>" placeholder="Default Port is 8000"></td>
			</tr>
			<tr>
				<td>Run as User:</td>
					<td><select name="runas" size="1" onChange="checkUSER(this.form);">
						<?=mk_option($webvirtmgr_runas, "nobody", "nobody");?>
						<?=mk_option($webvirtmgr_runas, "root", "root");?>
						<option value='other' <?=($webvirtmgr_runas != "root" && $webvirtmgr_runas != "nobody") ? "selected=yes":"";?>>other</option>
					</select>
					<input type="hidden" name="arg4" style="width:66%" maxlength="40" value="<?=$webvirtmgr_runas;?>">
				</td>
			</tr>
			<tr><td colspan="2"><div style="background-color:#FFFFFF;border:1px solid #000000;height:1px;width:100%;font-size:8px;"> </div></td></tr>
		<?if ($webvirtmgr_installed=="yes"):?>
			<tr>
					<td>Username:</td>
					<td>
					<select name="username" id="UsernameSelect" size="1" onChange="checkUSERNAME(this.form);">
						<option value="new" >new</option>
						<?php

						foreach ($webvirtmgr_userarray as $webvirtmgr_username)
						{
						echo "<option value = $webvirtmgr_username>$webvirtmgr_username</option>";
						}
						?>
					</select>
					<input type="text" name="arg5" style="width:68%" maxlength="40" value="" placeholder = "Enter New User">
					<input type="hidden" name="arg7" value="create">
					</td>
			</tr>
			<tr>
					<td>Password:</td>
					<td>
						<input type="password" name="arg6" value="" placeholder = "Enter Password for New User">
					</td>
			</tr>
		<? endif; ?>
		</table>
		<div align="center">
			<input type="submit" name="runCmd" value="Apply" style="margin-bottom:8px" onClick="verifyDATA(this.form);">
			<button type="button" style="margin-bottom:35px" onClick="done();">Done</button>
		</div>
	</form>
</div>

<script type="text/javascript">
function checkRUNNING(form) {
	if ("<?=$webvirtmgr_running;?>" == "yes")
	{
		form.arg2.readOnly = true;
		form.arg3.readOnly = true;
		form.arg4.readOnly = true;
		form.arg5.readOnly = true;
		form.arg6.readOnly = true;
		form.arg7.readOnly = true;
		form.runas.disabled = true;
   } 
   else
   {
		form.arg2.readOnly = (form.arg1.value == "enable");
		form.arg3.readOnly = (form.arg1.value == "enable");
		form.arg4.readOnly = (form.arg1.value == "enable");
		form.arg5.readOnly = (form.arg1.value == "enable");
		form.arg6.readOnly = (form.arg1.value == "enable");
		form.arg7.readOnly = (form.arg1.value == "enable");
		form.runas.disabled = (form.arg1.value == "enable");
   }
}
 
function checkUSER(form) {
	if (form.runas.selectedIndex < 2 ) {
		form.arg4.value = form.runas.options[form.runas.selectedIndex].value;
		form.arg4.type = "hidden";
	} else {
		form.arg4.value = "<?=$webvirtmgr_runas;?>";
		form.arg4.type = "text";
		form.arg4.placeholder = "Enter Run As User";
	}
}

function checkUSERNAME(form) {
	if (form.username.selectedIndex < 1 ) {
		form.arg5.value = "";
		form.arg5.type = "text";
		form.arg5.placeholder = "Enter New User";
		form.arg6.placeholder = "Enter Password for New User";
		form.arg7.value = "create";

	} else {
		form.arg5.value = form.username.options[form.username.selectedIndex].value;
		form.arg5.type = "hidden";
		form.arg6.placeholder = "Enter New Password for Selected User";
		form.arg7.value = "change";
	}
}

function verifyDATA(form) {
	if (form.arg2.value == null || !(/\S/.test(form.arg2.value))){
		form.arg2.value = "/usr/local/webvirtmgr";
	}
	if (isNumber(form.arg3.value)){
		if (form.arg3.value < 0 || form.arg3.value > 65535){
			form.arg3.value = "8000";
		}
	} else {
		form.arg3.value = "8000";
	}
	if (form.arg4.value == ""){
		form.arg4.value = "nobody";
	}
	if (form.arg5.value == ""){
		form.arg5.value = "";
	}
	if (form.arg6.value == ""){
		form.arg6.value = "";
	}
	if (form.arg7.value == ""){
		form.arg7.value = "";
	}
	form.arg1.value = form.arg1.value.replace(/ /g,"_");
	form.arg2.value = form.arg2.value.replace(/ /g,"_");
	form.arg3.value = form.arg3.value.replace(/ /g,"_");
	form.arg4.value = form.arg4.value.replace(/ /g,"_");
	form.arg5.value = form.arg5.value.replace(/ /g,"_");
	form.arg6.value = form.arg6.value.replace(/ /g,"_");
	form.arg7.value = form.arg7.value.replace(/ /g,"_");
}

function checkENABLE(form) {
	if (form.enable.checked == false ) {
		form.arg1.value = "disable";
	} else {
		form.arg1.value = "enable";
	}
}

checkUSER(document.webvirtmgr_settings);
checkUSERNAME(document.webvirtmgr_settings);
checkENABLE(document.webvirtmgr_settings);
</script>
