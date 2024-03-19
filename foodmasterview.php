<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Master</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="datatable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="datatable.js"></script>
    <script src="foodmaster.js?=<?php echo rand() ?>"></script>
</head>
<body>
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div style="text-align: center;background-image: linear-gradient(#3f95ff, #3155a8);color: white;">
                    <span style="display: block;font-size: 15px;font-weight: bold;">IDSoft Solution</span>
                    <span style="display: block;font-size: 19px;font-weight: bold;">Foodmaster and Report</span>
                </div>
                <hr style="margin-top: 5px;margin-bottom: 5px;">
            </div>
        </div>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Food Type:</label>
                            <select name="" id="foodtype_id" class="form-control">
                                <option value="">-Select-</option>
                                <option value="All">All</option>
                                <option value="Vegetables">Vegetables</option>
                                <option value="Fruits">Fruits</option>
                                <option value="Grains">Grains</option>
                                <option value="Protein Foods">Protein Foods</option>
                                <option value="Oils and Solid Fats">Oils and Solid Fats</option>
                                <option value="Added Sugars">Added Sugars</option>
                                <option value="Beverages">Beverages</option>
                            </select>
                        </div>
                        <div class="col-lg-6" style="margin-top: 26px;">
                            <button type="button" class="btn btn-warning btn-sm" id="search_btn">Search</button>
                            <button type="button" class="btn btn-primary btn-sm" id="create_new">Create New</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div id="datalist"></div>
        </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<!-- form modal -->
<div class="modal fade" id="formmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">ADD NEW ITMES</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">Food Type:</label>
                        <select name="" id="Vegetables" class="form-control">
                            <option value="">-Select-</option>
                            <option value="Vegetables">Vegetables</option>
                            <option value="Fruits">Fruits</option>
                            <option value="Grains">Grains</option>
                            <option value="Protein Foods">Protein Foods</option>
                            <option value="Oils and Solid Fats">Oils and Solid Fats</option>
                            <option value="Added Sugars">Added Sugars</option>
                            <option value="Beverages">Beverages</option>

                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="">Food Name:</label>
                        <input type="text" class="form-control" id="food_name" placeholder="Food Name">
                    </div>



                    <div class="col-lg-3">
                        <label for="">Mrp:</label>
                        <input type="number" class="form-control" id="mrp" placeholder="Mrp">
                    </div>

                    <div class="col-lg-3">
                        <label for="">Selling Price:</label>
                        <input type="number" class="form-control" id="selling_price" placeholder="SP">
                    </div>

                </div>


                <div class="row">

                    <div class="col-lg-3">
                        <label for="">Total QTY:</label>
                        <input type="number" class="form-control" id="Total_QTY" placeholder="TQTY">
                    </div>

                    <div class="col-lg-3">
                        <label for="">QTY left:</label>
                        <input type="number" class="form-control" id="QTY_left" placeholder="QTY left">
                    </div>

                    <div class="col-lg-3">
                        <label for="">Image:</label>
                        <input type="file" id="image" class="form-control">
                    </div>

                    <div class="col-lg-2">
                        <label for="">Date:</label>
                        <input type="date" id="date" class="form-control">
                    </div>



                    <div class="col-lg-1" style="margin-top: 26px;">
                        <button type="button" class="btn btn-primary btn-sm" id="save_btn">Save</button>
                        <input type="hidden" id="fooditemId">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="imagemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">FOOD IMAGE</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="imagbody"></div>

            </div>
        </div>
    </div>
</div>









<style>
    .imagesizemodal {
        width: 100%;
    }

    .card {
        background-color: white;
        border: 1px solid #cdcdcd;
        border-radius: 5px;
        padding: 10px 5px 10px 5px;
        box-shadow: -1px 5px 24px -12px;
    }
</style>