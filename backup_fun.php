<?php

    function after_insert_buyer()
    {
        $db = Xcrud_db::get_instance();

        // $pid=$db->insert_id();

        $pid = $postdata->get('pid');
        $weight = $postdata->get('weight');
        $amount = $postdata->get('amount');
        $pcid = $postdata->get('pcid');
        $name = $postdata->get('name');
        $pdate = $postdata->get('pdate');
        $duedate = $postdata->get('duedate');
        $rate = $postdata->get('rate');
        $weighttype = $postdata->get('weighttype');
        $type = $postdata->get('type');
        $sql = "INSERT INTO stock_new(purchase_id,pcid,name,amount,pdate,duedate,rate,weight,weighttype,type) VALUES('$pid','$pcid','$name','$amount','$pdate','$duedate','$rate','$weight','$weighttype','$type')";
        $db->query($sql);
    }

    function after_update_purchase($postdata, $primary, $xcrud)
    {
        $db = Xcrud_db::get_instance();

        // $pid=$db->insert_id();

        $pid = $db->escape($primary);
        $no_day = $postdata->get('no_of_days');
        $no_day = $no_day * 86400;
        $pdate = strtotime($postdata->get('pdate'));
        $total = $pdate + $no_day;
        $duedate = date('Y-m-d', $total);
        $purchase_rate = $postdata->get('rate');
        $purchase_weight = $postdata->get('weight');
        $purchase_amount = $purchase_rate * $purchase_weight;
        $sql = 'UPDATE `purchase` SET `duedate`="' . $duedate . '",`amount`=' . $purchase_amount . ' WHERE `pid`= ' . $pid;
        $db->query($sql);
        /*
        *
        *       Update STOCK TABLE
        *
        *
        */
        $db1 = Xcrud_db::get_instance();
        $weight = $postdata->get('weight');
        $amount = $purchase_amount;
        $pcid = $postdata->get('pcid');
        $name = $postdata->get('name');
        $pdate = $postdata->get('pdate');

        // $duedate=$postdata->get('duedate');

        $rate = $postdata->get('rate');
        $weighttype = $postdata->get('weighttype');
        $type = $postdata->get('type');

        // $upd = "UPDATE stock_new SET pcid = $pcid,name = '".$name."',amount = $amount,pdate ='$pdate',duedate = '$duedate',rate = $rate,weight = $weight WHERE purchase_id = $pid ";

        $upd1 = 'UPDATE `stock_new` SET `name`="' . $name . '",`amount`=' . $amount . ',`pdate`="' . $pdate . '",`duedate`="' . $duedate . '",`rate`=' . $rate . ',`weight`=' . $weight . ' WHERE `purchase_id`= ' . $pid;
        $db1->query($upd1);
    }

    function after_update_st($postdata, $xcrud)
    {
        $db = Xcrud_db::get_instance();
        $purchase_id = $postdata->get('purchase_id');
        /*
        *
        *  SElECTING SUM OF AMOUNT FROM PROCESS
        *
        */
        $sel = "SELECT SUM(amount) AS amount FROM process WHERE purchase_id=" . $purchase_id;
        $db->query($sel);
        $result = $db->result();

        // $from=$result[0]['purchase_id'];

        $result = $result[0];

        //   print_r($result);

        $sel = "SELECT  amount FROM purchase WHERE pid=" . $purchase_id;
        $db->query($sel);
        $result1 = $db->result();

        // $from=$result[0]['purchase_id'];

        $result1 = $result1[0];
        $purchase_amount = $result1['amount'];

        //    $amount= $postdata->get('amount');

        $weight = $postdata->get('weight');
        $stock_amount = $result['amount'];

        // $stock_weight=$result['weight'];

        $total = $stock_amount + $purchase_amount;
        $new_rate = $total / $weight;
        $total = floatval($total);
        print_r($total);
        $sql = "UPDATE stock_new SET amount=$total, weight=$weight,rate=$new_rate WHERE purchase_id=$purchase_id";
        $db->query($sql);
    }

    /*
    *
    * BEFORE UPDATE purchase date
    *
    */

    function no_days($postdata, $primary, $xcrud)
    {
        $db = Xcrud_db::get_instance();
        $no_day = $postdata->get('no_of_days');
        $no_day = $no_day * 86400;
        $pdate = strtotime($postdata->get('pdate'));
        $total = $pdate + $no_day;
        $date = date('Y-m-d', $total);
        $purchase_rate = $postdata->get('rate');
        $purchase_weight = $postdata->get('weight');
        $purchase_amount = $purchase_rate * $purchase_weight;
        $sql = 'UPDATE `purchase` SET `duedate`="' . $date . '",`amount`=' . $purchase_amount . ' WHERE `pid`= ' . $db->escape($primary);
        $db->query($sql);
        /*
        *
        * INSERT INTO STOCK
        *
        *
        *
        */
        /*
        $db1->query($sql);
        $pid = $postdata->get('pid');
        $weight=$postdata->get('weight');
        $amount=$postdata->get('amount');
        $pcid=$postdata->get('pcid');
        $name=$postdata->get('name');
        $pdate=$postdata->get('pdate');

        //  $duedate=$postdata->get('duedate');

        $rate=$postdata->get('rate');
        $weighttype=$postdata->get('weighttype');
        $type=$postdata->get('type');
        $sql1="INSERT INTO stock_new(purchase_id,pcid,name,amount,pdate,duedate,rate,weight,weighttype,type) VALUES('$pid','$pcid','$name','$amount','$pdate','$date','$rate','$weight','$weighttype','$type')";
        $db1->query($sql1);
        */
    }

    function after_insert_stock($postdata, $xcrud)
    {
        $db = Xcrud_db::get_instance();
        $sell_purchase_id = $postdata->get('seid');

        // $purchase_id=$result['purchase_id'];

        $sel = "SELECT * FROM selling WHERE seid=" . $sell_purchase_id;
        $db->query($sel);
        $result = $db->result();
        $result = $result[0];
        $old_weight = $result['weight'];
        $new_sell_weight = $postdata->get('weight');

        // $stock_weight=$result['weight']-$sell_weight;

        $stock_weight = $old_weight - $new_sell_weight;

        // $stock_pid=$result['seid'];
        // $sql = "UPDATE stock_new SET weight=$stock_weight WHERE purchase_id=$sell_purchase_id";

        $db->query($sql);
    }

    function get_amount($postdata, $xcrud)
    {
        $db = Xcrud_db::get_instance();
        $pid = $db->insert_id();
        $purchase_rate = $postdata->get('rate');
        $purchase_weight = $postdata->get('weight');
        $purchase_amount = $purchase_rate * $purchase_weight;
        $sql = 'UPDATE `selling` SET `amount`=' . $purchase_amount . ' WHERE `sid`= ' . $pid;
        $db = Xcrud_db::get_instance();
        $db->query($sql);

        // $postdata->set('amount', ( $postdata->get('weight * rate')));
        // $postdata->set('amount',$purchase_amount);

      

    }

    function new_get_amount($postdata, $primary, $xcrud)
    {
        $db = Xcrud_db::get_instance();
        $pid = $postdata->get('seid');
        $purchase_rate = $postdata->get('rate');
        $purchase_weight = $postdata->get('weight');
        $purchase_amount = $purchase_rate * $purchase_weight;
        $sql = 'UPDATE `selling` SET `amount`=' . $purchase_amount . ' WHERE `seid`= ' . $pid;
        $db = Xcrud_db::get_instance();
        $db->query($sql);

        // $postdata->set('amount', ( $postdata->get('weight * rate')));
        // $postdata->set('amount',$purchase_amount);

        /*
        *
        *   FOR WEIGHT UPDATE
        *
        *
        */
        $db1 = Xcrud_db::get_instance();
        $sell_purchase_id = $postdata->get('seid');

        // $purchase_id=$result['purchase_id'];

        $sel = "SELECT * FROM selling WHERE seid=" . $sell_purchase_id;
        $db1->query($sel);
        $result = $db1->result();
        $result = $result[0];
        $old_weight = $result['weight'];
        $new_sell_weight = $postdata->get('weight');

        // $stock_weight=$result['weight']-$sell_weight;

        $stock_weight = $old_weight - $new_sell_weight;

        // $stock_pid=$result['seid'];
        // $sql1 ="UPDATE stock_new SET weight=$stock_weight WHERE purchase_id=$sell_purchase_id";
        // $db1->query($sql1);

        /*
        *
        *   UPDATE NEW STOCK WEIGHT
        *
        */
        $db2 = Xcrud_db::get_instance();
        $sell_purchase_id = $postdata->get('seid');

        // $purchase_id=$result['purchase_id'];

        $sel2 = "SELECT * FROM stock_new WHERE purchase_id=" . $sell_purchase_id;
        $db2->query($sel2);
        $result1 = $db2->result();
        $result1 = $result1[0];
        $stock_weight_new = $result1['weight'];
        $new_stock_weight = $result1['weight'] - $stock_weight;

        // $upd = "UPDATE stock_new SET weight=$new_stock_weight WHERE purchase_id=$sell_purchase_id";
        // $db2->query($upd);

        $db3 = Xcrud_db::get_instance();
        $sell_no_day = $postdata->get('no_of_days');
        $sell_id = $postdata->get('sid');
        $sell_no_day = $sell_no_day * 86400;
        $selling_date = strtotime($postdata->get('selling_date'));
        $total = $selling_date + $sell_no_day;
        $s_date = date('Y-m-d', $total);
        $sql3 = 'UPDATE `selling` SET `duedate`="' . $s_date . '" WHERE `sid`= ' . $db->escape($primary);
        $db3->query($sql3);
        
        /*
        *
        *
        *   WEIGHT VALIDATION
        *
        */
        $db4 = Xcrud_db::get_instance();
        $sell_purchase_id = $postdata->get('seid');
        $sel4 = "SELECT * FROM stock_new WHERE purchase_id=" . $sell_purchase_id;
        $db1->query($sel4);
        $result4 = $db1->result();
        $result4 = $result4[0];
        $stock_weight = $result4['weight'];
        $sell_weight = $postdata->get('weight');
        $total_weight = $stock_weight - $sell_weight;
        echo $total_weight;
        if ($sell_weight < $stock_weight)
        {
            $db2 = Xcrud_db::get_instance();
            $sell_purchase_id = $postdata->get('seid');

            // $upd = "UPDATE stock_new SET weight=$total_weight WHERE purchase_id=$sell_purchase_id";
            // $db2->query($upd);

            echo "Your Remaining weight is" . $total_weight;
        }
        else
        {
            echo "Sell weight not greater then stock weight" . $total_weight;
        }
    }

    function insert_new_stock_after_purchase($postdata, $xcrud)
    {
        $db = Xcrud_db::get_instance();
        $id = $db->insert_id();
        $no_day = $postdata->get('no_of_days');
        $no_day = $no_day * 86400;
        $pdate = strtotime($postdata->get('pdate'));
        $total = $pdate + $no_day;
        $duedate = date('Y-m-d', $total);
        $purchase_rate = $postdata->get('rate');
        $purchase_weight = $postdata->get('weight');
        $purchase_amount = $purchase_rate * $purchase_weight;
        $sql = 'UPDATE `purchase` SET `duedate`="' . $duedate . '",`amount`=' . $purchase_amount . ' WHERE `pid`= ' . $id;
        $db->query($sql);
        $pid = $id;
        $weight = $postdata->get('weight');
        $amount = $purchase_amount;
        $pcid = $postdata->get('pcid');
        $name = $postdata->get('name');
        $pdate = $postdata->get('pdate');
        $rate = $postdata->get('rate');
        $weighttype = $postdata->get('weighttype');
        $type = $postdata->get('type');
        $sql1 = "INSERT INTO stock_new(purchase_id,pcid,name,amount,pdate,duedate,rate,weight,weighttype,type) VALUES('$pid','$pcid','$name','$amount','$pdate','$duedate','$rate','$weight','$weighttype','$type')";
        $db->query($sql1);
    }

    /*
    *
    *
    *       UPDATE DUE DATE IN SELLING
    *
    */

    function due_date($postdata, $primary, $xcrud)
    {
        /*
        $db3 = Xcrud_db::get_instance();
        $sell_no_day = $postdata->get('no_of_days');
        $sell_no_day = $sell_no_day * 86400;
        $selling_date = strtotime($postdata->get('selling_date'));
        $total = $selling_date + $sell_no_day;
        $s_date = date('Y-m-d', $total);
        $sql3 = 'UPDATE `selling` SET `duedate`="' . $s_date . '" WHERE `sid`= ' . $db->escape($primary);
        $db3->query($sql3);  */
        /*
        *
        *
        *   WEIGHT VALIDATION
        *
        */
        $db1 = Xcrud_db::get_instance();
        $sell_purchase_id = $postdata->get('seid');
        $sel = "SELECT * FROM stock_new WHERE purchase_id=" . $sell_purchase_id;
        $db1->query($sel);
        $result = $db1->result();
        $result = $result[0];
        $stock_weight = $result['weight'];
        $sell_weight = $postdata->get('weight');
        $total_weight = $stock_weight - $sell_weight;
        echo $total_weight;
        if ($sell_weight < $stock_weight)
        {
            $db2 = Xcrud_db::get_instance();
            $sell_purchase_id = $postdata->get('seid');

            // $upd = "UPDATE stock_new SET weight=$total_weight WHERE purchase_id=$sell_purchase_id";
            // $db2->query($upd);

            echo "Your Remaining weight is" . $total_weight;
        }
        else
        {
            echo "Sell weight not greater then stock weight" . $total_weight;
        }
    }

    /*
    *
    *
    *   VALIDATION FOR THE WEIGHT....
    *
    */

    function validate_weight()
    {
        $db = Xcrud_db::get_instance();
        $sell_purchase_id = $postdata->get('seid');
        $sel = "SELECT * FROM stock_new WHERE purchase_id=" . $sell_purchase_id;
        $db->query($sel);
        $result = $db->result();
        $result = $result[0];
        $stock_weight = $result['weight'];
        $sell_weight = $postdata->get('weight');
        $total_weight = $stock_weight - $sell_weight;
        if ($stock_weight < $sell_weight)
        {
            echo "Your Remaining weight is" . $total_weight;
        }
        else
        {
            echo "Sell weight not greater then stock weight";
        }
    }

?>
