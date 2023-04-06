<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo session('success'); ?> <a href="" id="close-msg"><span class="la la-times-circle"></span></a>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo session('error'); ?> <a href="" id="close-msg"><span class="la la-times-circle"></span></a>
    </div>
<?php endif; ?>
<?php /**PATH /Users/cornel/Documents/Projects/cmams/resources/views/admin/flash_msg.blade.php ENDPATH**/ ?>