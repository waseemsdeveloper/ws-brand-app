<?php

/*
* Company : Dropskit
* email : support@dropskit.com
*/

session_start();

if (isset($_SESSION['user']) == true) {
} else {
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand App</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/01a2f6f91c.js" crossorigin="anonymous"></script>
    <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.semanticui.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="css/ws.brandapp.css">

</head>

<body>

    <div id="overlay">
        <div id="text">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Processing Data Please Wait. . .</p>
        </div>
    </div>

    <div class="container">
        <div class="control">
            <div class="row">
                <div class="col">
                    <div class="input-group col-sm-6 col-md-8">
                        <input type="text" name="brand_name" class="form-control brand-inp" id="brand-inp" placeholder="Enter brand name" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn addNewBrand" type="button" id="addNewBrand">Add</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group col-sm-6 col-md-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input upload-inp" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile04">upload CSV file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn addNewBrand" id="uploadCsv" type="button">Import</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div id="status" class="text-center mt-2"> </div>
            </div>

            <div class="" style="margin-top: 30px;">
                <button id="exportSelected" class="btn btn-primary btn-lg ml-3">Export Selected</button>
                <button id="exportCurrent" class="btn btn-warning text-white ml-4 btn-lg">Export Current Page</button>
                <button id="exportAll" class=" btn btn-danger ml-4 btn-lg">Export All</button>

                <div class="float-right mr-3">
                    <button id="deleteSelected" class="btn btn-lg">Delete Selected</button>
                    <!--<button id="deleteAll" class="btn btn-lg">Delete All</button>-->
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-center">
            <div class="table-content">
                <table class="ui celled table" id="datatable">
                    <thead class="thead-dark">
                        <tr class="">
                            <th data-orderable="false" scope="col" class="text-primary" style="width: 45px;">
                                <p class="text-center pl-2">
                                    <input type="checkbox" name="" id="selectAll" class="">
                                </p>
                            </th>
                            <th scope="col" class="text-primary">Brand Name</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.semanticui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>

    <script src="scripts/ws.js.js"> </script>

</body>

</html>