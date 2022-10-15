<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
      <title>UAT | shurjoPay </title>
    </head>
    <body>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="img">
              <img src="assets/image/shurjopay-logo.png" alt="" class="center">
              <hr>
            </div>                       
              <form id="regForm" method="post" action="shurjoPay_payment.php">
                <div class="tab">
                  <center><h4>Payment amount</h4></center>
                  <p><input type="text" placeholder="Enter Payment Amount ( i.e 2 tk)" id="pamount" name="pamount" required ></p>
                </div>                
                <center>
                    <button type="submit" id="submit" name="submit">Submit</button>
                </center>                
                </div>
              </form>
          </div>
        </div>
      </div>
      
    
    </body>
</html>