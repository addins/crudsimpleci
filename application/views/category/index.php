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
        $no = $view_model['page_num'] + 1;
        $even = TRUE;
        $nodata = TRUE;
        foreach ($view_model['categories']->result() as $row):
            $nodata = FALSE;
            ?>
            <tr class="<?= $even = !$even ? 'even' : '' ?>">
                <td><?= $no++ ?></td>
                <td><?= $row->name ?></td>
                <td><?= $row->description ?></td>
                <td>
                    <a href="<?= base_url() ?>category/view/<?= $row->id ?>">View</a> | 
                    <a href="<?= base_url() ?>category/form/<?= $row->id ?>">Edit</a> | 
                    <a href="<?= base_url() ?>category/delete/<?= $row->id ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($nodata): ?>
            <tr><td colspan="4" style="text-align: center">no data found</td></tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td><a href="<?= base_url() ?>category/form">Add</a></td>
            <td colspan="3">
            </td>
        </tr>
    </tfoot>
</table>

<div class="row">
    <div class="large-12 columns">

        <?= form_open('category/index') ?>
        <div class="row">
            <div class="large-2 columns">
                <div class="row collapse">
                    <div class="small-8 columns">
            <!--            <input type="text" name="item_per_page" placeholder="Items per page">-->
                        <select name="item_per_page" id="item_per_page">
                            <option <?=$view_model['item_per_page']==='3'?'selected':''?>>3</option>
                            <option <?=$view_model['item_per_page']==='5'?'selected':''?>>5</option>
                            <option <?=$view_model['item_per_page']==='10'?'selected':''?>>10</option>
                        </select>
                    </div>
                    <div class="small-4 columns">
                        <button href="#" class="button postfix">Go</button>
                    </div>
                </div>
            </div>
            </form>

            <?= $view_model['paging'] ?>
        </div>
    </div>