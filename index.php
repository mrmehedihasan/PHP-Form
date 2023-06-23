<?php

// require "lib/fpdf/fpdf.php";

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont("Arial", "B", 16);
// $pdf->Cell(40, 10, "Hello World!");
// $pdf->Output();

session_start();

if (!isset($_SESSION["uid"])) {
  $_SESSION["uid"] = uniqid();
}

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
  // form was submitted
  $name = $_POST["name"];
  $father = $_POST["father"];
  $mother = $_POST["mother"];
  $contact = $_POST["contact"];
  $birthday = $_POST["birthday"];
  $education = $_POST["education"];
  $cgpa = $_POST["cgpa"];
  $interest = $_POST["interest"];

  $errors = [];

  // validate name
  if (empty($name)) {
    $errors["name"] = "Name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    $errors["name"] = "Only letters and white space allowed";
  }

  // validate father name
  if (empty($father)) {
    $errors["father"] = "Father name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $father)) {
    $errors["father"] = "Only letters and white space allowed";
  }

  // validate mother name
  if (empty($mother)) {
    $errors["mother"] = "Mother name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $mother)) {
    $errors["mother"] = "Only letters and white space allowed";
  }

  // validate contact
  if (empty($contact)) {
    $errors["contact"] = "Contact number is required";
  } elseif (!preg_match("/^[0-9]{11}$/", $contact)) {
    $errors["contact"] = "Invalid contact number";
  }

  // validate birthday
  if (empty($birthday)) {
    $errors["birthday"] = "Date of birth is required";
  }

  // validate education
  if (empty($education) || $education === "------------") {
    $errors["education"] = "Educational background is required";
  }

  // validate result
  if (empty($cgpa)) {
    $errors["cgpa"] = "Result is required";
  } elseif (!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $cgpa)) {
    $errors["cgpa"] = "Invalid result";
  }

  // validate interest
  if ($interest === "------------" || empty($interest)) {
    $errors["interest"] = "Please select anoption";
  }

  if (empty($errors)) {
    $_SESSION["name"] = $name;
    $_SESSION["father"] = $father;
    $_SESSION["mother"] = $mother;
    $_SESSION["contact"] = $contact;
    $_SESSION["birthday"] = $birthday;
    $_SESSION["education"] = $education;
    $_SESSION["cgpa"] = $cgpa;
    $_SESSION["interest"] = $interest;

    if (isset($_FILES["photo"])) {
      // upload the photo to static/photos

      $photo_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
      $file_name = $_SESSION["uid"] . "_" . $_FILES["photo"]["name"];
      $replace = str_replace(" ", "_", $file_name);

      if (!in_array($photo_ext, ["jpg", "jpeg", "png"])) {
        $_SESSION["photo"] = "default.png";
      } else {
        if (
          move_uploaded_file(
            $_FILES["photo"]["tmp_name"],
            "static/photos/" . $replace
          )
        ) {
          $_SESSION["photo"] = $replace;
        }
      }
    }

    header("Location: payment.php");
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
      </div>
    </div>

    <div class="mx-auto p-4" style="max-width: 700px">
      <form method="post"  enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label">Name<b>*</b></label>
          <input type="text" class="form-control" id="name" name="name" value="<?php if (
            isset($name)
          ) {
            echo $name;
          } ?>" />
          <div id="name_help" class="form-text text-danger"><b> <?php if (
            isset($errors["name"])
          ) {
            echo $errors["name"];
          } ?> </b></div>
        </div>

        <div class="mb-3">
          <label for="father" class="form-label">Father Name<b>*</b></label>
          <input type="text" class="form-control" id="father" name="father" value="<?php if (
            isset($father)
          ) {
            echo $father;
          } ?>" />
          <div id="father_help" class="form-text text-danger"><b>
            <?php if (isset($errors["father"])) {
              echo $errors["father"];
            } ?>
          
        </b></div>
        </div>

        <div class="mb-3">
          <label for="mother" class="form-label">Mother Name<b>*</b></label>
          <input type="text" class="form-control" id="mother" name="mother" value="<?php if (
            isset($mother)
          ) {
            echo $mother;
          } ?>" />
          <div id="mother_help" class="form-text text-danger"><b> 
            <?php if (isset($errors["mother"])) {
              echo $errors["mother"];
            } ?>

          </b></div>
        </div>

        <div class="mb-3">
          <label for="contact" class="form-label">Contact<b>*</b></label>
          <input type="text" class="form-control" id="contact" name="contact" value="<?php if (
            isset($contact)
          ) {
            echo $contact;
          } ?>" />
          <div id="contact_help" class="form-text text-danger"><b>
            <?php if (isset($errors["contact"])) {
              echo $errors["contact"];
            } ?>
        
        </b></div>
        </div>

        <div class="mb-3">
          <label for="birthday" class="form-label">Date of Birth<b>*</b></label>
          <input
            type="date"
            class="form-control"
            id="birthday"
            name="birthday"
            value="<?php if (isset($birthday)) {
              echo $birthday;
            } ?>"
          />
          <div id="birthday_help" class="form-text text-danger"><b>
            <?php if (isset($errors["birthday"])) {
              echo $errors["birthday"];
            } ?>
              
        
          </b></div>
        </div>

        <div class="mb-3">
          <label for="education" class="form-label" 
            >Educational Background<b>*</b></label
          >
          <select
            class="form-select"
            aria-label="Default select example"
            name="education"
            value ="<?php if (isset($education)) {
              echo $education;
            } ?>"
          >
            <option selected>------------</option>
            <option value="HSC">HSC</option>
            <option value="DIP">DIPLOMA</option>
          </select>

          <div id="education_help" class="form-text text-danger"><b>
            <?php if (isset($errors["education"])) {
              echo $errors["education"];
            } ?>    
        </b></div>
        </div>

        <div class="mb-3">
          <label for="cgpa" class="form-label">Result<b>*</b></label>
          <input type="text" class="form-control" id="cgpa" name="cgpa" value="<?php if (
            isset($cgpa)
          ) {
            echo $cgpa;
          } ?>" />
          <div id="cgpa_help" class="form-text text-danger">
            <b>
            <?php if (isset($errors["cgpa"])) {
              echo $errors["cgpa"];
            } ?>
          </b>
          </div>
        </div>

        <div class="mb-3">
          <label for="interest" class="form-label">Interest<b>*</b></label>
          <select
            class="form-select"
            aria-label="Default select example"
            name="interest"
            value ="<?php if (isset($interest)) {
              echo $interest;
            } ?>"
          >
            <option>------------</option>
            <option value="CSE">CSE</option>
            <option value="EEE">EEE</option>
            <option value="BBA">BBA</option>
            <option value="BCMB">BCMB</option>
          </select>

          <div id="interest_help" class="form-text text-danger"><b> 

            <?php if (isset($errors["interest"])) {
              echo $errors["interest"];
            } ?>

          </b></div>
        </div>

        <div class="mb-3">
          <label for="photo" class="form-label">Photo</label>
          <input
            type="file"
            class="form-control"
            id="photo"
            name="photo"
            accept="image/*"
          />
        </div>

        <button type="submit" class="btn btn-primary">Next</button>
      </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
      integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
