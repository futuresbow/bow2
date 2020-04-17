<table style="width:100%">
	<?php foreach($idLista as $id): $t = new Termek_osztaly($id);?>
	<tr>
		<td style="height: 5px;background:#045EE6"></td>
	</tr>
	
	
	<tr>
		<td style="">
			<a style="font-size:20px ;color:#E6045E;font-weight:bold;" href="<?= $t->link();?>"  title="" class="title">
				<img border="0" width="600" src="<?= base_url(). ws_image($t->fokep(),'big');?>" />
			</a>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;"><a style="font-size:20px ;color:#E6045E;font-weight:bold;" href="<?= $t->link();?>"  title="" class="title"><?= $t->jellemzo('Név'); ?></a></td>
	</tr>
	<tr>
		<td style="text-align:center;font-size:18px;"> <?= PN_ELO.' '.ws_arformatum($t->ar).' '.PN_UTO; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
