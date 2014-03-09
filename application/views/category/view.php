<?php
if(isset($view_model))$values = $view_model['category']->row();
?>
    <div class="row">
        <div class="large-4 medium-4 columns">
            <label>Category name</label>
            <p><?=isset($values->name)?$values->name:''?></p>
        </div>
    </div>
    <div class="row">
        <div class="large-4 medium-4 columns">
            <label>Category description</label>
            <p><?=isset($values->description)?$values->description:''?></p>
        </div>
    </div>
    <div class="row">
        <div class="large-4 medium-4 columns">
            <a class="" href="<?=base_url()?>category">Back to list</a>
        </div>
    </div>
