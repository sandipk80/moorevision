<?php
include('cnf.php');
require_once(LIB_PATH.'index-init.php');
include(LIB_HTML . 'header.php');
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.scrollTo.js"></script>
<!-- Main Container Starts -->
<div class="container">
    <?php include(LIB_HTML.'message.php');?>

    <!-- Welcome Section Starts -->
    <section class="welcome-area">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h3 class="main-heading1"><span class="lite">Welcome to </span></h3>
                <h3 class="main-heading2">Moore Vision Optometry</h3>
                <p class="topmargin20">
                    For over 20 years we’ve been proud to serve the city of Los Angeles. With affordable and high quality eye care, Moore Vision makes sure to take care of all of our patient's needs.
                </p>
                <p>
                    We take all major vision insurance carriers. Please call us today to verify, and book your appointment!
                </p>
            </div>
            <div class="col-md-6 col-xs-12">
                <img src="<?php echo IMG_PATH;?>eye.png" alt="" class="img-responsive img-style1">
            </div>
        </div>
    </section>
    <!-- Welcome Section Ends -->
</div>
<!-- Main Container Ends -->
<!-- Meet Our Doctors Section Starts -->
<section class="featured-doctors topmargin20">
    <!-- Nested Container Starts -->
    <div class="container">
        <h2>Meet Our Doctor</h2>
        <div class="row">
            <?php
            if(is_array($arrDoctors) && count($arrDoctors)>0){
                if(count($arrDoctors) > 1){
                    foreach ($arrDoctors as $doc){
                        if ($doc['picture'] !== "" && file_exists(STORAGE_PATH . 'doctors/' . $doc['picture'])) {
                            $docImage = STORAGE_HTTP_PATH . 'doctors/' . $doc['picture'];
                        } else {
                            $docImage = STORAGE_HTTP_PATH . 'doctors/no-image.jpg';
                        }
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="bio-box">
                    <div class="profile-img">
                        <img src="<?php echo $docImage;?>" alt="Doctor" class="img-responsive img-center-sm img-center-xs">
                    </div>
                    <div class="inner">
                        <h5><?php echo ucwords($doc['name']);?></h5>
                        <!--<p class="designation"><?php echo $doc['servname'].', '.$doc['catname'];?></p>-->
                        <p class="divider"><i class="fa fa-plus-square"></i></p>
                        <p>
                            <?php echo $doc['intro_text'];?>
                        </p>
                    </div>
                    <a href="<?php echo USER_SITE_URL.'book-appointment.php?cid='.$doc['catid'].'&sid='.$doc['servid'].'&d='.$doc['id'];?>" class="btn btn-transparent inverse text-uppercase">Book An Appointment</a>
                </div>
            </div>
            <?php
                    }
                }else{
                    $doc = $arrDoctors[0];
                    if ($doc['picture'] !== "" && file_exists(STORAGE_PATH . 'doctors/' . $doc['picture'])) {
                        $docImage = STORAGE_HTTP_PATH . 'doctors/' . $doc['picture'];
                    } else {
                        $docImage = STORAGE_HTTP_PATH . 'doctors/no-image.jpg';
                    }
            ?>
                <div class="col-md-6 col-lg-6 col-xs-12">
                    <img src="<?php echo $docImage;?>" alt="" width="80%" />
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12">
                    <div class="inner">
                        <h5><?php echo ucwords($doc['name']);?></h5>
                        <!--<p class="designation"><?php echo trim($doc['servname'].', '.$doc['catname'],",");?></p>-->
                        <p>
                            <?php echo $doc['intro_text'] ? $doc['intro_text'] : 'With over 20 years of experience, Dr Tarun Khosla specializes in pediatrics, geriatrics, contact lenses and ocular disease.';?>
                        </p>
                    </div>
                    <p class="text-center topmargin20"><button type="button" class="btn btn-info font24 brd-outline-wht" onclick="book_appointment('<?php echo $doc['catid'];?>','<?php echo $doc['servid'];?>','<?php echo $doc['id'];?>');">Book an Appointment</button></p>
                    <!--<p class="text-center topmargin20"><button type="button" class="btn btn-info font24 brd-outline-wht" onclick="send_message('');">Send Message</button></p>-->
                </div>
            <?php
                }
            }
            ?>
        </div>

    </div>
    <!-- Nested Container Ends -->
</section>
<!-- Meet Our Doctors Section Ends -->
<!-- Main Container Starts -->
<div class="container main-container">
    <!-- Medical Services Section Starts -->
    <section class="medical-services" id="services">
        <h2 class="main-heading2 topmargin20">Our Services</h2>
        <p class="topMarg20">We offer professional, personalized eye care, Frames adjustments, eyeglasses repairs. We also have an onsite laboratory to provide a faster service as fast as 30 minutes for most Rx, also carry eyeglass accessories (eyeglass cases, cleaners, cleaning clothes, eyeglass chains and much more. Whatever your vision needs are we are here to do an excellent job on your prescription, and help you choose the right frame to accommodate that prescription.</p>
        <p>We also carry contact lenses</p>
    </section>
    <!-- Medical Services Section Ends -->
    <!-- Content Starts -->
    <div class="row">
        <!-- Latest News Section Starts -->
        <section class="col-md-12 col-xs-12" id="selection">
            <div class="main-block1">
                <h2 class="main-heading2">Our Selection</h2>
                <div class="col-md-6 col-lg-6 col-xs-12 topmargin20">
                    <img src="<?php echo IMG_PATH;?>sunglasses.png" alt="" width="98%" />
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 no-padding">
                    <p class="text-left topmargin20">Find huge selections of brand name glasses for men, women, and kids. Moore Vision Optometry provides a variety of eyeglass frames, including trendy, classic, light weight, colorful and luxury.</p>
                    <p class="text-left">Ray-Ban, Gucci, Prada, Roberto Cavalli, Mont Blanc, Tag Heuer, Choppard, Versace, D&G, Fred, Gotti, Polo, Kenneth Cole, Tom Ford, Ermenegildo Zegna, Salvatore Ferragamo, and other private labels.</p>
                </div>
            </div>
        </section>
        <!-- Latest News Section Ends -->

    </div>
    <!-- Content Ends -->
    <!-- Book Appointment Box Starts -->
    <div class="book-appointment-box">
        <div class="row">
            <div class="col-md-5 col-xs-12 text-center-sm text-center-xs">
                <h4>Book your Appointment Online</h4>
                <h3><i class="fa fa-phone-square"></i> <?php echo MOORE_SUPPORT_PHONE;?></h3>
            </div>
            <div class="col-md-4 col-xs-12 text-center-sm text-center-xs">
                <a href="<?php echo USER_SITE_URL;?>book-appointment.php" class="btn btn-main text-uppercase">Book your Appointment</a>
            </div>
            <div class="col-md-3 col-xs-12 hidden-sm hidden-xs">
                <div class="box-img">
                    <img src="<?php echo IMG_PATH;?>exam.png" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Book Appointment Box Ends -->
</div>
<!-- Main Container Ends -->
<script type="text/javascript">
$("#navServices").click(function() {
    $('html, body').animate({
        scrollTop: $("#services").offset().top
    }, 2000);
});
$("#navSelection").click(function() {
    $('html, body').animate({
        scrollTop: $("#selection").offset().top
    }, 2000);
});
$(document).ready(function() {

});
function book_appointment(cid,sid,dt){
    location.href = "<?php echo USER_SITE_URL;?>book-appointment.php?cid="+cid+"&sid="+sid+"&d="+dt;
    return false;
}
function send_message(did){
    location.href = "<?php echo USER_SITE_URL;?>message.php?room="+did;
    return false;
}
</script>
<?php include(LIB_HTML . 'footer.php');?>