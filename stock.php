<?php
        require_once("xcrud/xcrud.php");
        $xcrud = Xcrud::get_instance();
        $xcrud->table('stock_new');
     
        $xcrud->label('weight','Total Weight');
        $xcrud->label('pdate','Purchase Date');
        $xcrud->label('weighttype','Weight Type');
        
        $xcrud->unset_csv();    
        $xcrud->unset_print();
        $xcrud->unset_view();
   
        $xcrud->columns('purchase_id,pcid,name,amount,pdate,duedate,rate,rate,weight,weighttype,type,Sold,Remaining Weight,status'); 
        $xcrud->subselect('Sold','SELECT SUM(weight) FROM selling WHERE seid = {purchase_id}');
        $xcrud->subselect('Remaining Weight','{weight}-{Sold}');
        $xcrud->highlight_row('Remaining Weight', '<=', 0, '#9ADAFF');
        //$xcrud->sum('weight,sell_weight,total'); // sum row(), receives data from full table (ignores pagination)
       //$xcrud->change_type('Balance','amount','0',array('prefix'=>'$')); // number format
       
  
  
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
