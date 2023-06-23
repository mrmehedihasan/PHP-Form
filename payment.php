<?php
session_start();

$mobile_banking = [
  ["method" => "bKash", "account_number" => "01742860106"],
  ["method" => "Nagad", "account_number" => "01742860106"],
];

$payment_amount = 100;

if (
  isset($_SESSION["name"]) &&
  $_SESSION["name"] != "" &&
  isset($_SESSION["father"]) &&
  $_SESSION["father"] != "" &&
  isset($_SESSION["mother"]) &&
  $_SESSION["mother"] != "" &&
  isset($_SESSION["contact"]) &&
  $_SESSION["contact"] != "" &&
  isset($_SESSION["birthday"]) &&
  $_SESSION["birthday"] != "" &&
  isset($_SESSION["education"]) &&
  $_SESSION["education"] != "" &&
  isset($_SESSION["cgpa"]) &&
  $_SESSION["cgpa"] != "" &&
  isset($_SESSION["interest"]) &&
  $_SESSION["interest"] != ""
) {
  $first_success_msg = "First form submission successful";
} else {
  header("Location: index.php");
}

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
  // form was submitted
  $amount = $_POST["amount"];
  $trxid = $_POST["trxid"];

  $errors = [];

  if (empty($amount) || !is_numeric($amount)) {
    $errors["amount"] = "Amount is required and must be numeric";
  }

  if (empty($trxid)) {
    $errors["trxid"] = "Trxid is required";
  }

  if (empty($errors)) {
    $_SESSION["amount"] = $amount;
    $_SESSION["trxid"] = $trxid;

    header("Location: success.php");
  }
}

// if there are no errors, process the form data if (empty($errors)) { // process the form data // … }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />

    <style>
      .logo {
        max-width: 400px;
        object-fit: contain;
      }
      @media (max-width: 600px) {
        .logo {
          width: 300px;
        }
      }
    </style>
  </head>
  <body>
    <header class="d-flex justify-content-center">
      <div class="p-4">
        <img class="logo" src="static/logo.png" alt="" />
      </div>
    </header>

    <div class="d-flex justify-content-center">
      <div style="max-width: 700px">
        <h2 class="text-center">
          Trust University Skill Development Course Registration
        </h2>
        <div class="alert alert-success">
        <?php if (isset($first_success_msg)) {
          echo $first_success_msg .
            " as <b> " .
            $_SESSION["name"] .
            " </b> and contact <b> " .
            $_SESSION["contact"] .
            " </b>";
        } ?>

        </div>  

        <div class="alert alert-warning">
        <h6 class="text-center">Please pay <?php echo $payment_amount; ?>  via mobile banking to following number </h6>
        <div class="d-flex flex-column align-items-center">
            <?php foreach ($mobile_banking as $banking) {
              echo "<div>" .
                $banking["method"] .
                " :  <b>" .
                $banking["account_number"] .
                "</b></div>";
            } ?>
        </div>

        </div> 
    
    </div>
    </div>

    <div class="mx-auto p-4" style="max-width: 700px">
      <form method="post"  enctype="multipart/form-data">
        <div class="mb-3">
          <label for="amount" class="form-label">Amount<b>*</b></label>
          <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?php if (
            isset($amount)
          ) {
            echo $amount;
          } ?>" />
          <div id="amount_help" class="form-text text-danger"><b> <?php if (
            isset($errors["amount"])
          ) {
            echo $errors["amount"];
          } ?> </b></div>
        </div>

        <div class="mb-3">
          <label for="trxid" class="form-label">Transaction ID <b>*</b></label>
          <input type="text" class="form-control" id="trxid" name="trxid" value="<?php if (
            isset($trxid)
          ) {
            echo $trxid;
          } ?>" />
          <div id="trxid_help" class="form-text text-danger"><b>
            <?php if (isset($errors["trxid"])) {
              echo $errors["trxid"];
            } ?>
          
        </b></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
      integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
