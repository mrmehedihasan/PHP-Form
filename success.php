<?php
session_start();
$msg = "";
if (
  !(
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
    $_SESSION["interest"] != "" &&
    isset($_SESSION["amount"]) &&
    $_SESSION["amount"] != "" &&
    isset($_SESSION["trxid"]) &&
    $_SESSION["trxid"] != "" &&
    isset($_SESSION["uid"]) &&
    $_SESSION["uid"] != ""
  )
) {
  header("Location: payment.php");
} else {
  require_once "DB.php";
  $uid = $_SESSION["uid"];

  if (!isset($_SESSION["photo"])) {
    $_SESSION["photo"] = "default.png";
  }
  $stmt = $pdo->prepare(
    "INSERT INTO users (uid, name, father, mother, contact, birthday, education, cgpa, interest, amount, trxid, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
  );
  $stmt->execute([
    $uid,
    $_SESSION["name"],
    $_SESSION["father"],
    $_SESSION["mother"],
    $_SESSION["contact"],
    $_SESSION["birthday"],
    $_SESSION["education"],
    $_SESSION["cgpa"],
    $_SESSION["interest"],
    $_SESSION["amount"],
    $_SESSION["trxid"],
    $_SESSION["photo"],
  ]);

  // Check if the insert was successful
  if ($stmt->rowCount() > 0) {
    $msg = "You application submitted successful.";
    unset($_SESSION["name"]);
    unset($_SESSION["father"]);
    unset($_SESSION["mother"]);
    unset($_SESSION["contact"]);
    unset($_SESSION["birthday"]);
    unset($_SESSION["education"]);
    unset($_SESSION["cgpa"]);
    unset($_SESSION["interest"]);
    unset($_SESSION["amount"]);
    unset($_SESSION["trxid"]);
    unset($_SESSION["photo"]);
    unset($_SESSION["uid"]);
  } else {
    echo "Error: " . $stmt->error;
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
          <h5 class="text-center"><?php echo $msg; ?></h5>

          <a href="pdf.php?uid=<?php echo $uid; ?>">Download Form</a>

        <hr>
        </div>  
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
      integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
