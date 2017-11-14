<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
require_once(LIB_PATH.'doctors/dashboard-init.php');
include(LIB_HTML . 'doctors/header.php');
include(LIB_HTML . 'doctors/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1>Dashboard</h1>
        <p class="description">Welcome to Doctor Portal</p>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active"><a href="<?php echo DOCTOR_SITE_URL;?>dashboard.php">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
            <?php include(LIB_HTML . 'message.php');?>

            <a href="javascript:void(0);"><div class="col-md-3">
                <div class="panel panel-solid-info widget-mini">
                    <div class="panel-body">
                        <i class="icon-user"></i>
                        <span class="total text-center"><?php echo $openTickets;?></span>
                        <span class="title text-center">Open Tickets</span>
                    </div>
                </div>
            </div></a>

            <a href="javascript:void(0);"><div class="col-md-3">
                <div class="panel panel-solid-success widget-mini">
                    <div class="panel-body">
                        <i class="icon-bar-chart"></i>
                        <span class="total text-center"><?php echo $pendingTickets;?></span>
                        <span class="title text-center">Pending Tickets</span>
                    </div>
                </div>
            </div></a>

            <a href="javascript:void(0);"><div class="col-md-3">
                <div class="panel widget-mini">
                    <div class="panel-body">
                        <i class="icon-envelope-open"></i>
                        <span class="total text-center"><?php echo $closedTickets;?></span>
                        <span class="title text-center">Closed Tickets</span>
                    </div>
                </div>
            </div></a>

            <a href="javascript:void(0);"><div class="col-md-3">
                <div class="panel widget-mini">
                    <div class="panel-body">
                        <i class="icon-envelope-open"></i>
                        <span class="total text-center"><?php echo $comingAppointments;?></span>
                        <span class="title text-center">Coming Appointments</span>
                    </div>
                </div>
            </div></a>

            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Patients</h3>
                        <div class="actions pull-right">
                            <button class="btn btn-default" id="btnAddPatient">Add Patient</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>DOB</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(is_array($arrPatients) && count($arrPatients)>0){
                                    foreach($arrPatients as $row){
                                        $msgUrl=DOCTOR_SITE_URL."message.php?room=".$row['id'];
                                        $address = $row['address'].", ".$row['city'].", ".$row['state']." - ".$row['zipcode'];
                                ?>
                                <tr>
                                    <td><?php echo ucwords($row['firstname'].' '.$row['lastname']);?></td>
                                    <td><?php echo $row['email'];?></td>
                                    <td><?php echo date("F d, Y", strtotime($row['date_of_birth']));?></td>
                                    <td><?php echo $address;?></td>
                                    <td><?php echo $row['phone'];?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo DOCTOR_SITE_URL.'patient.php?id='.$row['id'];?>">View</a>
                                        <a class="btn btn-danger" href="<?php echo $msgUrl;?>">Message</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    
                    <div class="panel-body">
                        <div class="col-md-4 bg-white ">
                            <div class="lt-member-header row border-bottom padding-sm text-center">
                                Patients
                            </div>
                            <div class="border-bottom padding-sm text-center topmarg10">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search_patient" id="txtSearchPatient" placeholder="Search Patient">
                                </div>
                            </div>
                            <!-- =============================================================== -->
                            <!-- member list -->
                            <ul class="friend-list">
                                <?php
                                if(is_array($arrPatients) && count($arrPatients)>0){
                                    foreach($arrPatients as $pRow){
                                        $patientImg = IMG_PATH.'user.jpg';
                                        if(isset($userId) && $userId==$pRow['userId']){
                                            $actClass = "active";
                                        }else{
                                            $actClass = "";
                                        }
                                        if($pRow['msg_date'] !== ""){
                                            $postedTime = UtilityManager::get_time_difference($pRow['msg_date']);
                                        }else{
                                            $postedTime = "";
                                        }
                                ?>
                                <li class="<?php echo $actClass;?> bounceInDown">
                                    <a href="<?php echo DOCTOR_SITE_URL.'message.php?room='.$pRow['userId'];?>" class="clearfix">
                                        <img src="<?php echo $patientImg;?>" alt="" class="img-circle">
                                        <div class="friend-name">   
                                            <strong><?php echo $pRow['username'];?></strong>
                                        </div>
                                        <div class="last-message text-muted"><?php echo $pRow['last_msg'];?></div>
                                        <small class="time text-muted"><?php echo $postedTime;?></small>
                                        <?php echo $pRow['msg_count']>0 ? '<small class="chat-alert label label-danger">'.$pRow['msg_count'].'</small>' : '';?>
                                    </a>
                                </li>
                                <?php
                                    }
                                }
                                ?>
                                                
                            </ul>
                        </div>

                        <!--=========================================================-->
                        <!-- selected chat -->
                        <div class="col-md-8 bg-white ">
                            <div class="chat-message display-message">
                                <ul class="chat">
                                    <?php
                                    if(is_array($arrMessages) && count($arrMessages)>0){
                                        foreach($arrMessages as $mRow){
                                            $timeAgo = UtilityManager::get_time_difference($mRow['msg_date']);
                                            if($mRow['msg_from'] == "D"){
                                    ?>
                                    <li class="left clearfix">
                                        <span class="chat-img pull-left">
                                            <img src="<?php echo $docImage;?>" alt="<?php echo $docname;?>">
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font"><?php echo $docname;?></strong>
                                                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?php echo $timeAgo;?></small>
                                            </div>
                                            <p>
                                                <?php echo $mRow['message'];?>
                                            </p>
                                            <?php
                                            if($mRow['attachment'] !== "" && file_exists(STORAGE_PATH.'messages/'.$mRow['attachment'])){
                                                $file_ext = pathinfo(STORAGE_PATH.'messages/'.$mRow['attachment'], PATHINFO_EXTENSION);
                                                if(in_array(strtolower($file_ext), $arrImgExtns)) {
                                                    echo '<p style="text-align:right;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'" alt="" class="msg-image"></a></p>';
                                                }elseif(in_array(strtolower($file_ext), $arrDocExtns)) {
                                                    echo '<p style="text-align:right;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/doc.jpg" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
                                                }elseif($file_ext=="pdf") {
                                                    echo '<p style="text-align:right;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/pdf.png" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                            }else{
                                    ?>
                                    <li class="right clearfix">
                                        <span class="chat-img pull-right">
                                            <img src="<?php echo IMG_PATH;?>user.jpg" alt="<?php echo $username;?>">
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font"><?php echo $username;?></strong>
                                                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?php echo $timeAgo;?></small>
                                            </div>
                                            <p>
                                                <?php echo $mRow['message'];?>
                                            </p>
                                            <?php
                                            if($mRow['attachment'] !== "" && file_exists(STORAGE_PATH.'messages/'.$mRow['attachment'])){
                                                $file_ext = pathinfo(STORAGE_PATH.'messages/'.$mRow['attachment'], PATHINFO_EXTENSION);
                                                if(in_array(strtolower($file_ext), $arrImgExtns)) {
                                                    echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'" alt="" class="msg-image"></a></p>';
                                                }elseif(in_array(strtolower($file_ext), $arrDocExtns)) {
                                                    echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/doc.jpg" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
                                                }elseif($file_ext=="pdf") {
                                                    echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/pdf.png" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                            }
                                        }
                                    }else{
                                        //echo '<li class="text-center">No message found</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="chat-box bg-white">
                                <form id="frmPostMessage" name="frmPostMessage" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                                        <input type="hidden" id="user_id" value="<?php echo base64_encode($userId); ?>">
                                        <textarea id="message" class="form-control border no-shadow no-rounded" placeholder="Type your message here"></textarea>
                                    </div>
                                    <div class="input-group">
                                        <div id="attachBtn">
                                            <input type="file" id="msgFile" name="msgFile"/> <img src="<?php echo IMG_PATH;?>attach.png" alt="Upload" />
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success no-rounded" type="submit" id="send-message">Send</button>
                                            <span id="loading" style="display:none;"><img src="<?php echo IMG_PATH;?>loading.gif" alt="loading"></span>
                                        </span>
                                    </div><!-- /input-group --> 
                                    <span id="error"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</section>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 0, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,5 ] }
        ]
    });

    //search patient
    $('#txtSearchPatient').keyup(function() {
        var pstr = $('#txtSearchPatient').val();
        $.ajax({
            url: "<?php echo AJAX_PATH;?>ajaxSearchPatient.php?p="+pstr+"&u=<?php echo $userId;?>",
            type: "GET",
            contentType: "html",
            processData: false,
            cache: false,
            success: function(data) {
                $('.friend-list').html(data);
            }
        });
    });

    /*post message via ajax*/
    $("#frmPostMessage").submit(function() {
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            user_id = $.trim($("#user_id").val()),
            error = $("#error");

        if(message !== "" && conversation_id !== "" && user_id != ""){
            $('#loading').show();
            var data = new FormData();
            data.append('conversation_id', $("#conversation_id").val());
            data.append('user_id', $("#user_id").val());
            data.append('message', $("#message").val());
            data.append('msgFile', $('input[name=msgFile]')[0].files[0]);
            $.ajax({
                url: "<?php echo AJAX_PATH;?>postDoctorMessage.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                success: function(data) {
                    $('#loading').hide();
                    $("#message").val("");
                    error.text("");
                }
            });
        }
        return false;
    });

    //get message
    c_id = $("#conversation_id").val();
    //get new message every 2 second
    setInterval(function(){
        $(".display-message").load("<?php echo AJAX_PATH;?>loadDoctorMessages.php?c_id="+c_id);
    }, 2000);

    $(".display-message").scrollTop($(".display-message")[0].scrollHeight);
});
$(document).on('click', '#btnAddPatient', function (e){
    window.location.href = "add-patient.php";
});

</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>