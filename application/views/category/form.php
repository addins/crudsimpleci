<?php
if(isset($view_model))$values = $view_model['category']->row();
else{
    if(isset($id))$values->id = $id;
}
?>
<?=form_open('category/form')?>
<input type="hidden" name="id" value="<?=isset($values->id)?$values->id:''?>"/>
    <div class="row">
        <div class="large-4 medium-4 columns">
            <label>Category name</label>
            <input type="text" name="name" placeholder="Category name" value="<?php echo set_value('name'); ?><?=isset($values->name)?$values->name:''?>">
        </div>
    </div>
    <div class="row">
        <div class="large-4 medium-4 columns">
            <label>Category description</label>
            <input type="text" name="description" placeholder="Category description" value="<?php echo set_value('description'); ?><?=isset($values->description)?$values->description:''?>">
        </div>
    </div>
    <div class="row">
        <div class="large-4 medium-4 columns">
            <button class="small radius button" type="submit">Save</button>
            <a class="small radius button" href="<?=base_url()?>category">Cancel</a>
            <button class="small radius secondary button" type="reset">Reset</button>
        </div>
    </div>
</form>