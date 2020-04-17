<?php if($keresoMezok):?>
<div class="box box-dark box-flat">
	<form class="keresoUrlap">
		  
<div class="input-group">
  <div class="input-group-prepend">
	<select class="custom-select" name="sr[keresomezo]" id="sel01">

						<?php if($keresoMezok): foreach($keresoMezok as $k => $mezo): ?>

						<option <?= @$_GET['keresomezo'] == $k?' selected ':''; ?> value="<?= $k; ?>"><?= $mezo['felirat']; ?></option>

						<?php endforeach; endif; ?>

					</select>
  
  </div>
  <input name="sr[keresoszo]" class="form-control keresoInput" type="text" value="<?= @$_GET['keresoszo']; ?>" placeholder="Keresés...">
			
  <div class="input-group-append">
    <input  type="submit" class="btn btn-outline-secondary" value="Keresés">
  </div>
</div>
		
	</form>
</div>
<br>
<?php endif; ?>
