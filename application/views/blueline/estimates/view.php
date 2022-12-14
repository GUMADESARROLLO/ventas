<script type="text/javascript">
	  //Ajax background load
	$(document).on('change', '.description-setter', function (e) {
	var itemid = $(this).val();

	


	var code = $('#itemc' + itemid).html();
	$('#code').val(code);
	
	});  
</script>

          <div class="row">
              <div class="col-xs-12 col-sm-12">
            <a href="<?=base_url()?>estimates/update/<?=$estimate->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><i class="icon dripicons-pencil visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_edit_estimate');?></span></a>
			<?php if ($estimate->estimate_status != 'Accepted' && $estimate->estimate_status != 'Invoiced') {
    ?><a href="<?=base_url()?>estimates/item/<?=$estimate->id; ?>" class="btn btn-primary" data-toggle="mainmodal"><i class="icon dripicons-plus visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_add_item'); ?></span></a><?php
} ?>

			<div class="btn-group">
			  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <?=$this->lang->line('application_pdf');?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="<?=base_url()?>estimates/preview/<?=$estimate->id;?>" ><?=$this->lang->line('application_download_pdf');?></a></li>
			    <li><a href="<?=base_url()?>estimates/preview/<?=$estimate->id;?>/show" target="_blank"><?=$this->lang->line('application_preview_pdf');?></a></li>
			  </ul>
			</div>

			<?php if (($estimate->estimate_status == 'Open' || $estimate->estimate_status == 'Revised') && is_object($estimate->company)) {
        ?><a href="<?=base_url()?>estimates/sendestimate/<?=$estimate->id; ?>" class="btn btn-primary"><i class="icon dripicons-mail visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_send_estimate_to_client'); ?></span></a><?php
    } ?>
			<?php if ($estimate->estimate_status == 'Accepted') {
        ?><a href="<?=base_url()?>estimates/estimateToInvoice/<?=$estimate->id; ?>" class="btn btn-success"><i class="icon dripicons-mail visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_convert_to_invoice'); ?></span></a><?php
    } ?>
			<?php if ($estimate->estimate_status == 'Invoiced') {
        ?><a href="<?=base_url()?>invoices/view/<?=$estimate->id; ?>" class="btn btn-success"><i class="icon dripicons-mail visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_go_to_invoice'); ?></span></a><?php
    } ?>


              </div>
          </div>
          <div class="row">

		<div class="col-md-12">
			<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_estimate_details');?></div>
		<div class="subcont">
		<ul class="details col-xs-12 col-sm-6">
			<li><span><?=$this->lang->line('application_estimate_id');?>:</span> <?=$core_settings->estimate_prefix;?><?=$estimate->estimate_reference;?></li>
			<li class="<?=$estimate->estimate_status;?>"><span><?=$this->lang->line('application_status');?>:</span>
			<?php $unix = human_to_unix($estimate->estimate_sent . ' 00:00');
                    $change_date = '';
                switch ($estimate->estimate_status) {
                    case 'Open': $label = 'label-default'; break;
                    case 'Accepted': $label = 'label-success'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;
                    case 'Sent': $label = 'label-warning'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($estimate->estimate_sent . ' 00:00')) . '"'; break;
                    case 'Declined': $label = 'label-important'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;
                      case 'Invoiced': $label = 'label-chilled'; $change_date = 'title="' . $this->lang->line('application_Accepted') . ' ' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;
                      case 'Revised': $label = 'label-warning'; $change_date = 'title="' . $this->lang->line('application_Revised') . ' ' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;

                    default: $label = 'label-default'; break;
                }
            ?>
			<a class="label <?=$label?> tt" <?=$change_date;?>><?=$this->lang->line('application_' . $estimate->estimate_status);?>
			</a>
			</li>
			<li><span><?=$this->lang->line('application_issue_date');?>:</span> <?php $unix = human_to_unix($estimate->issue_date . ' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<li><span><?=$this->lang->line('application_due_date');?>:</span> <?php $unix = human_to_unix($estimate->due_date . ' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<?php if (!empty($estimate->company->vat)) {
                ?> 
			<li><span><?=$this->lang->line('application_vat'); ?>:</span> <?php echo $estimate->company->vat; ?></li>
			<?php
            } ?>
			<?php if (is_object($estimate->project)) {
                ?>
			<li><span><?=$this->lang->line('application_projects'); ?>:</span> <?php echo $estimate->project->name; ?></li>
			<?php
            } ?>
			<span class="visible-xs"></span>
		</ul>
		<ul class="details col-xs-12 col-sm-6">
			<?php if (is_object($estimate->company)) {
                ?>
			<li><span><?=$this->lang->line('application_company'); ?>:</span> <a href="<?=base_url()?>clients/view/<?=$estimate->company->id; ?>" class="label label-info"><?=$estimate->company->name; ?></a></li>
			<li><span><?=$this->lang->line('application_contact'); ?>:</span> <?php if (is_object($estimate->company->client)) {
                    ?><?=$estimate->company->client->firstname; ?> <?=$estimate->company->client->lastname; ?> <?php
                } else {
                    echo '-';
                } ?></li>
			<li><span><?=$this->lang->line('application_street'); ?>:</span> <?=$estimate->company->address; ?></li>
			<li><span><?=$this->lang->line('application_city'); ?>:</span> <?=zip_position($estimate->company->zipcode, $estimate->company->city); ?></li>
			<li><span><?=$this->lang->line('application_province'); ?>:</span> <?php echo $estimate->company->province = empty($estimate->company->province) ? '-' : $estimate->company->province; ?></li>
			<?php
            } else {
                ?>
				<li><?=$this->lang->line('application_no_client_assigned'); ?></li>
			<?php
            } ?>
		</ul>
		<br clear="all">
		</div>
		</div>
		</div>
		</div>

		<div class="row">
		<div class="col-md-12">
		<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_items');?> <?php if ($estimate->estimate_status != 'Accepted' && $estimate->estimate_status != 'Invoiced') {
                ?><span class=" pull-right"><a href="<?=base_url()?>estimates/item/<?=$estimate->id; ?>" class="btn btn-md btn-primary" data-toggle="mainmodal"><i class="fa icon dripicons-plus visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_add_item'); ?></span></a></span> <?php
            } ?></div>
		<div class="table-div min-height-200">
		<table class="table noclick" id="items" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
		<th width="4%"><?=$this->lang->line('application_action');?></th>
			<th><?=$this->lang->line('application_code');?></th>
			<th><?=$this->lang->line('application_name');?></th>
			<th class="hidden-xs" width="8%"><?=$this->lang->line('application_type');?></th>
			<th class="hidden-xs" width="8%"><?=$this->lang->line('application_hrs_qty');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_description');?></th>
			<th class="hidden-xs" width="12%"><?=$this->lang->line('application_unit_price');?></th>
			<th class="hidden-xs" width="12%"><?=$this->lang->line('application_sub_total');?></th>
			<th class="hidden-xs" width="12%"><?=$this->lang->line('application_vence');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php foreach ($items as $value):?>
		<tr id="<?=$value->id;?>" >
		
		<td class="option" style="text-align:left;" width="8%">
				        <?php if ($estimate->estimate_status != 'Accepted' && $estimate->estimate_status != 'Invoiced') {
                ?>
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>estimates/item_delete/<?=$estimate->invoice_has_items[$i]->id; ?>/<?=$estimate->id; ?>'><?=$this->lang->line('application_yes_im_sure'); ?></a> <button class='btn po-close'><?=$this->lang->line('application_no'); ?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id; ?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete'); ?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>estimates/item_update/<?=$estimate->invoice_has_items[$i]->id; ?>" title="<?=$this->lang->line('application_edit'); ?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
						<?php
            } else {
                echo '<i class="btn-option icon dripicons-lock"></i>';
            }?>
			</td>
			<td class="hidden-xs" align="center"><?=$value->code;?></td>
			<td><?php if (!empty($value->name)) {
                echo $value->name;
            } else {
                echo $estimate->invoice_has_items[$i]->item->name;
            }?></td>
			<td class="hidden-xs" align="center"><?=$estimate->invoice_has_items[$i]->type;?></td>
			<td class="hidden-xs" align="center"><?=$estimate->invoice_has_items[$i]->amount;?></td>
			<td class="hidden-xs"><?=$estimate->invoice_has_items[$i]->description;?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf('%01.2f', $estimate->invoice_has_items[$i]->value));?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf('%01.2f', $estimate->invoice_has_items[$i]->amount * $estimate->invoice_has_items[$i]->value));?></td>
			<td class="hidden-xs" align="center"><?=$value->expira;?></td>

		</tr>
		
		<?php $sum = $sum + $estimate->invoice_has_items[$i]->amount * $estimate->invoice_has_items[$i]->value; $i++;?>
		
		<?php endforeach;
        if (empty($items)) {
            echo "<tr><td colspan='6'>" . $this->lang->line('application_no_items_yet') . '</td></tr>';
        }
        if (substr($estimate->discount, -1) == '%') {
            $discountpercent = true;
            $discount = sprintf('%01.2f', round(($sum / 100) * substr($estimate->discount, 0, -1), 2));
        } else {
            $discount = $estimate->discount;
        }
        $sum = $sum - $discount;

        if ($estimate->tax != '') {
            $tax_value = $estimate->tax;
        } else {
            $tax_value = $core_settings->tax;
        }

        if ($estimate->second_tax != '') {
            $second_tax_value = $estimate->second_tax;
        } else {
            $second_tax_value = $core_settings->second_tax;
        }

        $tax = sprintf('%01.2f', round(($sum / 100) * $tax_value, 2));
        $second_tax = sprintf('%01.2f', round(($sum / 100) * $second_tax_value, 2));

        $sum = sprintf('%01.2f', round($sum + $tax + $second_tax, 2));
        ?>
		<?php if ($discount != 0): ?>
		<tr>
			<td colspan="8" align="right"><?=$this->lang->line('application_discount');?> <?php if (isset($discountpercent)) {
            echo '(' . $estimate->discount . ')';
        }?></td>
			<td>- <?=display_money($discount);?></td>
		</tr>	
		<?php endif ?>
		<?php if ($tax_value != '0') {
            ?>
		<tr>
			<td colspan="8" align="right"><?=$this->lang->line('application_tax'); ?> (<?= $tax_value?>%)</td>
			<td><?=display_money($tax)?></td>
		</tr>
		<?php
        } ?>
		<?php if ($second_tax != '0') {
            ?>
		<tr>
			<td colspan="8" align="right"><?=$this->lang->line('application_second_tax'); ?> (<?= $second_tax_value?>%)</td>
			<td><?=display_money($second_tax); ?></td>
		</tr>
		<?php
        } ?>
		<tr class="active">
			<td colspan="8" align="right"><?=$this->lang->line('application_total');?></td>
			<td><?=display_money($sum, $estimate->currency);?></td>
		</tr>
		</table>
		
		</div>
		</div>
		<div class="row">


<div class=" col-md-12" align="right">
			



</div>	
</div>




<br>



		</div>
		</div>

		

