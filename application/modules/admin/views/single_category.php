
<div class="box-body">
    <!-- for category list (start) -->
    <div class="gallery text-center">
        <ul class="reorder-gallery" id="cat_list">
            <?php foreach ($catList as $rows): ?>
            
            <li id="<?php echo $rows->id; ?>" class="ui-sortable-handle imgBlock"><a href="javascript:void(0);"><img height="100" width="200" class=" img-thumbnail" src="<?php if(!empty($rows->image)){ echo base_url().CATEGORY_IMAGE_PATH.$rows->image; }else{ echo base_url().CATEGORY_DEFAULT_IMAGE; }?>" /><span><?php echo $rows->name ?></span></a>
            <span>
                <a href="javascript:void(0)" class="on-default edit-row fa-lg" onclick="editFn('admin/category','edit','<?php echo encoding($rows->id); ?>');" title="Edit Category"><?php echo EDIT_ICON; ?></a>
                <a href="javascript:void(0)" onclick="deleteFn('<?php echo CATEGORIES ?>','id','<?php echo encoding($rows->id); ?>','admin/category/','delete')" class="on-default edit-row text-danger fa-lg" title="Delete Category"><?php echo DELETE_ICON; ?></a>
                </span>
            </li>
           
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- for category list (end) -->
</div>
<!-- /.box-body -->
