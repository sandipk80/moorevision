<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'doctors/tickets/index-init.php');
include(LIB_HTML . 'doctors/header.php');
include(LIB_HTML . 'doctors/leftbar.php');
?>

<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo DOCTOR_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <button class="btn btn-default" id="btnAddTicket">Add Ticket</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="post" name="frmListing" id="frmListing" action="">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Patient Email</th>
                                            <th>Subject</th>
                                            <th>Priority</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $deleteItem=DOCTOR_SITE_URL."tickets.php?act=delete&id=".$row['id'];
                                                $closeItem=DOCTOR_SITE_URL."tickets.php?act=close&id=".$row['id'];
                                                $editItem=DOCTOR_SITE_URL."edit-ticket.php?act=edit&id=".$row['id'];
                                        ?>
                                        <tr>
                                            <td><?php echo ucwords($row['name']);?></td>
                                            <td><?php echo $row['email'];?></td>
                                            <td><a href="<?php echo DOCTOR_SITE_URL;?>ticket.php?id=<?php echo $row['id'];?>"><?php echo ucwords($row['subject']);?></a></td>
                                            <td><span id="priority<?php echo $row['id'];?>"><?php echo ucwords($row['priority']);?></span></td>
                                            <td><?php echo $row['catname'];?></td>
                                            <td>
                                                <span id="status<?php echo $row['id'];?>">
                                                <?php
                                                if($row['status']=="pending"){
                                                    echo "Order in Progress";
                                                }elseif($row['status']=="closed"){
                                                    echo "Order Completed";
                                                }else{
                                                    echo ucwords($row['status']);
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo date("F d, Y g:i A", strtotime($row['modified']));?></td>
                                            <td>
                                                <?php
                                                if($row['status'] !== "closed"){
                                                ?>
                                                <a class="btn btn-default half-btn" href="<?php echo $editItem;?>">Edit</a>
                                                <a class="btn btn-default half-btn" href="<?php echo $closeItem;?>">Close</a>
                                                <a class="btn btn-default half-btn modal_trigger" href="#status-popup" id="<?php echo $row['id'];?>">Change Status</a>
                                                <?php
                                                }
                                                ?>
                                                <a class="btn btn-danger half-btn" href="<?php echo $deleteItem;?>" onclick="javascript: return confirmDelete();">Delete</a>
                                                
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<div id="status-popup" class="popupContainer" style="display:none;">
    <header class="popupHeader">
        <span class="header_title">Change Ticket Status</span>
        <span class="modal_close"><i class="fa fa-times"></i></span>
    </header>
    <section class="popupBody">
    <form name="frmChangeStatus" id="frmChangeStatus" action="" method="post">
        <label>Priority</label>
        <select name="ticketpriority" id="ticketpriority" class="form-control">
            <option value="normal">Normal</option>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>
        <br>
        <label>Status</label>
        <select name="ticketstatus" id="ticketstatus" class="form-control">
            <option value="open">Open</option>
            <option value="pending">Order in Progress</option>
            <option value="closed">Order Completed</option>
        </select><br>
        <div class="action_btns">
            <input type="hidden" name="update-ticket-status" value="submit" />
            <input type="hidden" name="ticketId" id="ticketId" value="" />
            <input type="submit" class="btn btn-success btn-square" value="Submit" />
            <span id="loading" style="display:none;"><img src="<?php echo IMG_PATH;?>loading.gif" alt="loading"></span>
        </div>
    </form>
    </section>
</div>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>jquery.leanModal.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo CSS_SITE_URL;?>popup.css" />
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).on('click', '.modal_trigger', function (e){
    var tid = $(this).attr('id');
    $("#ticketId").val(tid);
    //find out the details of selected ticket
    $.ajax({
        url:'<?php echo AJAX_PATH;?>getTicketDetails.php?tid='+tid,
        cache: false,
        contentType: "application/json; charset=utf-8",
        dataType:"json",
        success:function(data){
            $.each(data, function(index, element) {
                if(index == "priority")
                    $("#ticketpriority").val(element);
                if(index == "status")
                    $("#ticketstatus").val(element);
            });
            $(".modal_trigger").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
        }
    });
    

});
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#ticketsPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 5, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,7 ] }
        ]
    });

    /*post message via ajax*/
    $("#frmChangeStatus").submit(function() {
        var tid = $("#ticketId").val(),
            status = $("#ticketstatus").val(),
            priority = $.trim($("#ticketpriority").val()),
            error = $("#error");

        if(tid !== "" && status !== "" && priority != ""){
            $('#loading').show();
            var data = new FormData();
            data.append('tid', tid);
            data.append('status', status);
            data.append('priority', priority);
            $.ajax({
                url: "<?php echo AJAX_PATH;?>postTicketStatus.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                success: function(data) {
                    $('#loading').hide();
                    $(".modal_close").click();
                    if(status="pending"){
                        $("#status"+tid).html("Order in Progress");
                    }else if(status="pending"){
                        $("#status"+tid).html("Order Completed");
                    }else{
                        $("#status"+tid).html(status);
                    }
                    $("#priority"+tid).html(priority);
                    error.text("");
                }
            });
        }
        return false;
    });

    $(document).on('click', '#btnAddTicket', function (e){
        window.location.href = "add-ticket.php";
    });
});

function confirmDelete() {
    if(!confirm("Are you sure you want to delete this ticket?")) {
        return false;
    }
    else {
        return true;
    }
}

</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'doctors/footer.php');?>