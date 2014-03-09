<?php
if(isset($view_model))$values = $view_model['category']->row();
?>
<?=form_open('category/delete')?>
<input type="hidden" name="id" value="<?=isset($values->id)?$values->id:''?>"/>
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
            <button class="small radius button" type="submit">Delete</button>
            <a class="small radius button" href="<?=base_url()?>category">Cancel</a>
        </div>
    </div>
</form>
