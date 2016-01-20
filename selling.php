<?php

  require_once("xcrud/xcrud.php");
  
   $xcrud = Xcrud::get_instance();
    $xcrud->table('selling');
    
     $xcrud->relation('scid','customer','cid','name');
    // $xcrud->relation('seid','purchase','pid','pid');
     
      $xcrud->relation('seid','stock_new','purchase_id','purchase_id');
    $xcrud->unset_csv();    
    $xcrud->unset_print();
   $xcrud->unset_view();
      //$xcrud->label('pdate','Date');
      $xcrud->label('weighttype','Weight Type');
   
    $xcrud->change_type('pdate','date');
    $xcrud->label('scid','Customer Name');
     $xcrud->label('seid','Purchase id');
      $xcrud->fields('amount',true);
      
      //$xcrud->where('weight >',0);
   $xcrud->after_insert('get_amount');
     // $xcrud->before_update('get_amount');
      $xcrud->after_update('new_get_amount');
    
      
     // $xcrud->before_update('after_insert_stock');
      //$xcrud->after_update('due_date');
      
       $xcrud->columns('scid,seid,name,amount,selling_date,duedate,no_of_days,rate,weight,weighttype,type,status');
    $xcrud->create_action('publish', 'publish_action'); // action callback, function publish_action() in functions.php
    $xcrud->create_action('unpublish', 'unpublish_action');
    $xcrud->button('#', 'unpublished', 'icon-close glyphicon glyphicon-remove', 'xcrud-action', 
        array(  // set action vars to the button
            'data-task' => 'action',
            'data-action' => 'publish',
            'data-primary' => '{sid}'), 
        array(  // set condition ( when button must be shown)
            'status',
            '!=',
            '1')
    );
    $xcrud->button('#', 'published', 'icon-checkmark glyphicon glyphicon-ok', 'xcrud-action', array(
        'data-task' => 'action',
        'data-action' => 'unpublish',
        'data-primary' => '{sid}'), array(
        'status',
        '=',
        '1'));
   
   
   
   
          
      
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
           
           
           
          //$xcrud->before_update('validate_weight'); 
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
