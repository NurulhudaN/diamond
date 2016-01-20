<?php

  require_once("xcrud/xcrud.php");
  
   $xcrud = Xcrud::get_instance();

    $xcrud->table('selling');
    
    $xcrud->columns('name,amount,selling_date,duedate,no_of_days,rate,weight,Purchase Detail'); 
    $xcrud->subselect('Purchase Detail','SELECT SUM(weight) FROM selling WHERE seid = {purchase_id}');
    
  
   
   
    
 
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
           
         $xcrud->after_update('after_update_st');
         $xcrud->after_insert('after_update_st');
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
