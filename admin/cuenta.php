<?php include ('header.php')?>
<h1>Mi Cuenta</h1>
<form method="post" action="backend.php?mod=Usuario&acc=EditarPass" onsubmit="return ValidaForm('EditaPass',this);">
<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" class="forma">
  <tr>
    <td width="22%">Contrase&ntilde;a</td>
    <td width="78%"><input type="password" name="password" id="password" /></td>
  </tr>
  <tr>
    <td>Confirma Contrase&ntilde;a</td>
    <td><input type="password" name="cPassword" id="cPassword" /></td>
  </tr>
</table>
<?php include ('footer.php')?>