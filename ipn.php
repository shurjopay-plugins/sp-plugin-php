<?php
 require_once 'ShurjopayPlugin.php';
  $spObject = new ShurjopayPlugin();
  $response_data = (object) array('Status'=>'No data found');

  if($_REQUEST['oid'])
  {
      $shurjopay_order_id = trim($_REQUEST['oid']);
      $response_data = json_decode(json_encode($spObject->verifyOrder($shurjopay_order_id)));
  }
//print_r($response_data);exit();

  try {
      $logmsg = "\n".date("Y.n.j H:i:s")."#".json_encode($response_data);
      file_put_contents(date("Y.n.j").'.log',$logmsg,FILE_APPEND);
      } catch(Exception $e) {
        file_put_contents(date("Y.n.j").'.log',$e->getMessage(),FILE_APPEND);
      }



?>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
    <body>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="img">
              <img src="assets/image/shurjopay-logo.png" alt="" class="center">
              <hr>
            </div>
            	
            	<table id="regForm" class="table table-hover">
            		<?php 

            			if(is_array($response_data)):
                    $response_data = array_shift($response_data);
            			foreach($response_data as $key => $val):

            		?>
            			<tr>
            				<td class="table-info"><?php echo $key?></td>
            				<td><?php print_r ($val);?></td>
            			</tr>
            		<?php
                    
            			endforeach;
            			endif;
                  
            		?>
            		<tr><td colspan="2"><a href="./ipnview.php"><b>Back</b></td></tr>
            	</table>
            
          </div>
        </div>
      </div>      
    </body>
</html>