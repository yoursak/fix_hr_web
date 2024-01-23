<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>My Payment Gateway</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

<body class="wsmenucontainer">
    <div class="container">
        <!-- Content Row -->
        <?php $merchant_id = "Merchant ID" ?>
        <div class="row">
            <div class="">
                <div class="">
                    <div class="col-md-9 col-sm-12 tour-paricular">
                        <div class="particular-box" style="padding:13px;">
                            <h2 class="heading_bottom">Payment Gateway CC Avenue</h2>
                            <form method="post" name="customerData" action="ccavRequestHandler.php">
                                @csrf
                                <table width="100%" height="100">
                                    <tr>
                                        <td colspan="2"> Compulsory information</td>
                                    </tr>
                                    <tr>
                                        <td>TID :</td>
                                        <td><input type="text" name="tid" id="tid"
                                                value="<?php echo(rand(11111,99999)); ?>" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td>Order Id :</td>
                                        <td><input type="text" name="order_id" id="order_id"
                                                value="<?php echo(rand(11111,99999)); ?>" readonly /></td>
                                    </tr>
                                    <tr class="hidden">
                                        <td>Merchant Id :</td>
                                        <td><input hidden type="text" name="merchant_id"
                                                value="<?php echo $merchant_id ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Amount:</td>
                                        <td><input type="text" name="amount" placeholder="Enter Amount" required></td>
                                    </tr>
                                    <tr>
                                        <td>Currency:</td>
                                        <td>
                                            <select name="currency">
                                                <option value="INR">Indian Rupees</option>
                                                <option value="USD">US Dollar</option>
                                                <option value="AUD">Australian Dollar</option>
                                                <option value="GBP">Pound Sterling</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <br>
                                    <tr class="hidden">
                                        <td>Redirect URL :</td>
                                        <td><input type="text" name="redirect_url"
                                                value="http://localhost/ccavenue/ccavResponseHandler.php" /></td>
                                    </tr>
                                    <tr class="hidden">
                                        <td>Cancel URL :</td>
                                        <td><input type="text" name="cancel_url"
                                                value="http://localhost/ccavenue/ccavResponseHandler.php" /></td>
                                    </tr>
                                    <tr class="hidden">
                                        <td>Language :</td>
                                        <td><input type="text" name="language" value="EN" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Billing Information</td>
                                    </tr>
                                    <tr>
                                        <td>Billing Name :</td>
                                        <td><input type="text" name="billing_name" placeholder="Mention your name"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td>Billing Address :</td>
                                        <td><input type="text" name="billing_address"
                                                placeholder="Mention your address" /></td>
                                    </tr>
                                    <tr>
                                        <td>Billing City :</td>
                                        <td><input type="text" name="billing_city" placeholder="Mention city name" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Billing State :</td>
                                        <td><input type="text" name="billing_state" Placeholder="Mention state name" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Billing Zip :</td>
                                        <td><input type="text" name="billing_zip" placeholder="Mention Zipcode" /></td>
                                    </tr>
                                    <tr>
                                        <td>Billing Country :</td>
                                        <td><input type="text" name="billing_country"
                                                placeholder="Mention country name"></td>
                                    </tr>
                                    <tr>
                                        <td>Billing Tel :</td>
                                        <td><input type="phone" name="billing_tel" placeholder="Mention contact number"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td>Billing Email :</td>
                                        <td><input type="email" name="billing_email" placeholder="Mention your email id"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><INPUT TYPE="submit" class="btn btn-primary" value="PROCEED"></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <!-- /.col-lg-8 -->
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
</body>

</html>