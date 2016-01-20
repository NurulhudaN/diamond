<?php

  require_once("xcrud/xcrud.php");
  
    $xcrud = Xcrud::get_instance();
    $xcrud->table('customer');
    $xcrud->unset_csv();    
    $xcrud->unset_print();
    $xcrud->unset_view();
   
   
    $xcrud->columns('name,address,phoneno,Purchase Amount,Selling Amount,Balance'); // specify only some columns
    
    $xcrud->label('name','Customer Name');
    $xcrud->label('phoneno','Phone No.');
    $xcrud->subselect('Purchase Amount','SELECT SUM(amount) FROM purchase WHERE pcid = {cid}'); 
    $xcrud->subselect('Selling Amount','SELECT SUM(amount) FROM selling WHERE scid = {cid}');
    $xcrud->subselect('Balance','{Selling Amount}-{Purchase Amount}'); // current table
     $xcrud->sum('Purchase Amount,Selling Amount,Balance');
   // $xcrud->change_type('Balance,Purchase Amount,Selling Amount','price','0',array('prefix'=>'$')); 
       // $xcrud->highlight_row('Remaining Weight', '<=', 0, '#9ADAFF');

?>

<!DOCTYPE html>
<html>
  <head>
    <?php include 'linkcss.php'; ?>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

    <?php include 'header.php' ?>
      <!-- Left side column. contains the logo and sidebar -->
     <?php include 'sidepanel.php' ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
       
          <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
           <?php
           echo $xcrud->render(); 
           ?>
            </div>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  
<?php include 'footer.php' ?>
    
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
<?php include 'xcrudjs.php'; ?>
 
  </body>
</html>
