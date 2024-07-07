<?php

require_once("config.php");
require_once("nav.php");

if(!isset($_SESSION['id'])){
    header('location:login.php');
}

if(isset($_POST['submit'])){
    $user_id = $_SESSION['id'];
    $item_id = $_GET['id'];
    $review = $_POST['review'];
    $stars = $_POST['stars'];
    $status = $_GET['status'];

    if($status == 'sale') {
      $sql = "INSERT INTO reviews (status, sale_item_id, rent_item_id, user_id, review, stars)
              VALUES('$status', '$item_id', null, '$user_id', '$review', '$stars')";
      mysqli_query($link, $sql);

      if(mysqli_affected_rows($link)>0){

        echo "<div class='w-100 m-2'>
        <div class='alert alert-success alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success!</strong> Review Sent.
        </div>";
        echo "<script>
          setTimeout(function() {
            window.location.href = 'itemsForSale.php?id={$_GET['id']}';
          }, 1000);
        </script>";
      } else {
        echo "<div class='w-100 m-2'>
        <div class='alert alert-primary alert-dismissible'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Error!</strong> No Review sent!
        </div>";
      }

    } elseif($status == 'rent') {
      $sql = "INSERT INTO reviews (status, sale_item_id, rent_item_id, user_id, review, stars)
              VALUES('$status', null, '$item_id', '$user_id', '$review', '$stars')";
      mysqli_query($link, $sql);

      if(mysqli_affected_rows($link)>0){

        echo "<div class='w-100 m-2'>
        <div class='alert alert-success alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success!</strong> Review Sent.
        </div>";
        echo "<script>
          setTimeout(function() {
            window.location.href = 'itemsForRent.php?id={$_GET['id']}';
          }, 3000);
        </script>";
      } else {
        echo "<div class='w-100 m-2'>
        <div class='alert alert-primary alert-dismissible'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Error!</strong> No Review sent!
        </div>";
      }
    }
}


?>

<h1 class="text-center mt-5">Add a Review</h1>

<div class="d-flex flex-column justify-content-evenly" style="min-height: 600px;">

    <form action="" method="post" class="d-flex flex-column justify-content-between" style="min-height: 320px;">
        <div class="d-flex flex-column justify-content-between mb-5">
            <h4 class="mt-5">Review:</h4>
            <textarea name="review" id="review"
            rows="8" cols="100" maxlength="2500"
            style="resize: none; outline: none;"
            class="border border-0 rounded p-3 fs-4" required></textarea>
        </div>
        <label for="stars" class="fs-4 fw-bold">Number of stars:</label>
        <input type="number" name="stars" id="stars" class="align-self-start border border-0 rounded p-2 fs-5"
        placeholder="0 to 5" min="0" max="5" step="0.1" style="outline: none;" required>
        <button type="submit" class="align-self-start btn btn-primary fs-5 mt-5" name="submit">Send Review</button>
    </form>
</div>

</div>

<?php
require_once("footer.php")
?>
</body>
</html>