<div class="box-item double">
				<?php if($input1):?>
                <div class="input-container <?= (isset($urlapHiba[$input1->data['mezonev']]))?' error ':'';?>">
                    <div class="label-container">
                        <label class="<?= (@$input1->data['kotelezo']!='')?'important':'';?>"><?= @$input1->data['felirat']; ?></label>
                        <?php if(isset($urlapHiba[$input1->data['mezonev']])):?>
                        <div class="error-tooltip">
                            <div class="icon">
                                <div class="tooltip-container">
                                    <div class="tooltip-msg">
                                        <?= $urlapHiba[$input1->data['mezonev']]; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="input-select-container">
						<?php if(@$input1->data['tipus']=='legordulo'):?>
						<div class="styled-select">
							<?= @$input1->kimenet(); ?>
                        </div>
						<?php else: ?>
                        <?= @$input1->kimenet(); ?>
						<?php endif; ?>
                    </div>
                </div>
                
                
                
                
                
                
				<?php endif;?>
               <?php if($input2):$r=rand(0,99999);?>
                <div class="input-container <?= (isset($urlapHiba[$input2->data['mezonev']]))?' error ':'';?>">
                    <div class="label-container">
                        <label  class="<?= (@$input2->data['kotelezo']!='')?'important':'';?>"><?= @$input2->data['felirat']; ?></label>
                        <?php if(isset($urlapHiba[$input2->data['mezonev']])):?>
                        
                        <div class="error-tooltip">
                            <div class="icon">
                                <div class="tooltip-container">
                                    <div class="tooltip-msg">
                                        <?= $urlapHiba[$input2->data['mezonev']]; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                     <div class="input-select-container">
						<?php if(@$input2->data['tipus']=='legordulo'):?>
						<div class="styled-select">
							<?= @$input2->kimenet(); ?>
                        </div>
						<?php else: ?>
                        <?= @$input2->kimenet(); ?>
						<?php endif; ?>
                    </div>
                </div>
				<?php endif;?>

               

            </div>
            
            
