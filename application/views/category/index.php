<table class="app-table-data">
    <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no=1; 
        $even = TRUE; 
        $nodata = TRUE; 
        foreach ($view_model['categories']->result() as $row):
            $nodata = FALSE;
            ?>
        <tr class="<?=$even=!$even?'even':''?>">
            <td><?=$no++?></td>
            <td><?=$row->name?></td>
            <td><?=$row->description?></td>
            <td><a href="category/view/<?=$row->id?>">View</a> | <a href="category/form/<?=$row->id?>">Edit</a> | <a href="category/delete/<?=$row->id?>">Delete</a></td>
        </tr>
        <?php endforeach;?>
        <?php if($nodata):?>
        <tr><td colspan="4" style="text-align: center">no data found</td></tr>
        <?php endif;?>
    </tbody>
    <tfoot>
        <tr><td colspan="4"><a href="category/form">Add</a></td></tr>
    </tfoot>
</table>
