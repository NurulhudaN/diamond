<?php

  require_once("xcrud/xcrud.php");
  
   $xcrud = Xcrud::get_instance();

    $xcrud->table('process');
    
    
    $xcrud->relation('purchase_id','stock_new','purchase_id','purchase_id');
    $xcrud->relation('process_type','process_type','process_type_id','process_type');
  
    $xcrud->unset_csv();    
    $xcrud->unset_print();
   $xcrud->unset_view();
   
  // $xcrud->change_type('process_type','select','select','Select type,rough,sign,laser,ghatt,polish');
 
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
