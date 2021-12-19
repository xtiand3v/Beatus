<?php require_once('db_connect.php') ?>
<style>
    #uni_modal .modal-footer{
        display:none
    }
</style>
<div class="container-fluid">
    <form action="" id="receive-po">
        <div class="form-group">
            <label class="control-label">Purchase Order Code</label>
            <select name="po_id" id="po_id" class="custom-select custom-select-sm select2">
                <option></option>
                <?php 
                $po = $conn->query("SELECT * FROM purchase_order where status = 0 order by po_code asc");
                while($row = $po->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($po_id) && $po_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['po_code']) ?></option>
            <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="row justify-content-end">
                    <button class="btn btn-sm btn-primary mr-2" id="rpo-submit" type="submit" form="receive-po">Receive</button>
                    <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('.select2').select2({
            width:'100%'
        })
        $('#rpo-submit').click(function(){
            $('#receive-po').submit()
        })
        $('#receive-po').submit(function(e){
            e.preventDefault()
            if($('#po_id').val() <= 0){
                alert_toast("Please select Purchase Order Code first.",'warning')
                return false;
            }
            location.href= './index.php?page=manage_receiving&po='+$("#po_id").val()
        })
    })
    
</script>