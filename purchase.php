<?php

  require_once("xcrud/xcrud.php");
  
   $xcrud = Xcrud::get_instance();
    $xcrud->table('purchase');
   $xcrud->relation('pcid','customer','cid','name');
    $xcrud->unset_csv();    
    $xcrud->unset_print();
   $xcrud->unset_view();
   $xcrud->label('companyname','Company Name');
   $xcrud->label('pdate','Date');
    $xcrud->label('pcid','Customer Name');
    $xcrud->change_type('pdate','date');
   // $xcrud->columns('duedate',true);
    $xcrud->fields('duedate,amount', true);
    

                // $xcrud->before_insert('no_days');
               
               $xcrud->after_insert('insert_new_stock_after_purchase');
               $xcrud->after_update('after_update_purchase');
            
    
    
 
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
