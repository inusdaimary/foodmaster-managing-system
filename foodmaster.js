$(document).on('click', '#save_btn', function () {

    var foodtype = $('#Vegetables').val();
    var foodname = $('#food_name').val();
    var mrp = $('#mrp').val();
    var sellingprice = $('#selling_price').val();
    var Total_QTY = $('#Total_QTY').val();
    var QTY_left = $('#QTY_left').val();
    var date = $('#date').val();
    var fooditemId = $('#fooditemId').val();

    var image = $('#image')[0];
    var form_data = new FormData();

    form_data.append('foodtype', foodtype);
    form_data.append('foodname', foodname);
    form_data.append('mrp', mrp);
    form_data.append('sellingprice', sellingprice);
    form_data.append('Total_QTY', Total_QTY);
    form_data.append('QTY_left', QTY_left);
    form_data.append('date', date);
    form_data.append('fooditemId', fooditemId);
    form_data.append('image', image.files[0]);
    form_data.append('status', '1');
    form_data.append('req_type', 'savefooditems');

   
    $.ajax({
        type: "post",
        url: "foodmastercontroller.php",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.status == 1) {
                alert(response.message);
            }
            $('#fooditemId').val('');
            $('#Vegetables').val('');
            $('#food_name').val('');
            $('#mrp').val('');
            $('#Status').val('');
            $('#fooditemId').val('');
            $('#date').val('');
            $('#selling_price').val('');
            $('#Total_QTY').val('');
            $('#QTY_left').val('');
            $('#image').val('');
            $('#formmodal').modal("hide");
            getfoodatalist();

        }
    });
})




$(document).on('click', '#search_btn', function () {

    getfoodatalist();

})


$.ajax({
    type: "post",
    url: "foodmastercontroller.php",
    data: {
        'foodtype': 'All',
        'req_type': 'getfooddatalist'
    },
    dataType: "json",
    success: function (response) {
        console.log(response);

        if (response.status == 1) {

            $('#datalist').empty().append(response.table);

            $('#fooddatatbale').DataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                'paging': '200px',
                lengthMenu: [[4, 10, 25, 50, -1], [2, 10, 25, 50, "All"]],
                'bSort': false,
                columnDefs: [
                    { width: '3%', targets: 0 },
                    { width: '7%', targets: 1 },
                    { width: '7%', targets: 2 },
                    { width: '7%', targets: 3 },
                    { width: '7%', targets: 4 },
                    { width: '7%', targets: 5 },
                    { width: '7%', targets: 6 },
                    { width: '5%', targets: 7 },
                    { width: '4%', targets: 8 },
                    { width: '4%', targets: 9 },
                    { width: '4%', targets: 10 },
                    { width: '4%', targets: 11 },
                    // { visible: false, targets: 12 }
                ]

            });
        } else if (response.status == 2) {
            alert(response.message);
        }
    }
});


function getfoodatalist() {
    var foodtype = $('#foodtype_id').val();


    $.ajax({
        type: "post",
        url: "foodmastercontroller.php",
        data: {
            'foodtype': foodtype,
            'req_type': 'getfooddatalist'
        },
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.status == 1) {

                $('#datalist').empty().append(response.table);

                $('#fooddatatbale').DataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    'paging': '200px',
                    lengthMenu: [[4, 10, 25, 50, -1], [2, 10, 25, 50, "All"]],
                    'bSort': false,
                    columnDefs: [
                        { width: '3%', targets: 0 },
                        { width: '7%', targets: 1 },
                        { width: '7%', targets: 2 },
                        { width: '7%', targets: 3 },
                        { width: '7%', targets: 4 },
                        { width: '7%', targets: 5 },
                        { width: '7%', targets: 6 },
                        { width: '5%', targets: 7 },
                        { width: '4%', targets: 8 },
                        { width: '4%', targets: 9 },
                        { width: '4%', targets: 10 },
                        { width: '4%', targets: 11 },
                        // { visible: false, targets: 12 }
                    ]

                });
            } else if (response.status == 2) {
                alert(response.message);
            }
        }
    });

}


$(document).on('click', '#edit_btn', function () {



    var id = $(this).closest('tr').find('td').eq(1).text();
    var foodtype = $(this).closest('tr').find('td').eq(2).text();
    var foodname = $(this).closest('tr').find('td').eq(3).text();
    var Mrp = $(this).closest('tr').find('td').eq(4).text();
    var sellingprice = $(this).closest('tr').find('td').eq(5).text();
    var totalqty = $(this).closest('tr').find('td').eq(6).text();
    var qtyleft = $(this).closest('tr').find('td').eq(7).text();
    var Date = $(this).closest('tr').find('td').eq(8).text();

    $('#fooditemId').val(id);
    $('#Vegetables').val(foodtype).change();
    $('#food_name').val(foodname).change();
    $('#mrp').val(Mrp);
    $('#selling_price').val(sellingprice);
    $('#Total_QTY').val(totalqty);
    $('#QTY_left').val(qtyleft);
    $('#date').val(Date);

    $('#formmodal').modal("show");

})


$(document).on('click', '#delete_btn', function () {

    var id = $(this).closest('tr').find('td').eq(1).text();



    $.ajax({
        type: "post",
        url: "foodmastercontroller.php",
        data: {
            'id': id,
            'req_type': 'deletefooditems'
        },
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.status == 1) {

                alert(response.message)


            }

            getfoodatalist();
        }
    });

})


$(document).on('click', '#status_btn_a', function () {

    var id = $(this).closest('tr').find('td').eq(1).text();
    var status = '0'
    $.ajax({
        type: "post",
        url: "foodmastercontroller.php",
        data: {
            'id': id,
            'status': status,
            'req_type': 'updatestatus'
        },
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.status == 1) {

                //  alert(response.message)


            }

            getfoodatalist();
        }
    });



})


$(document).on('click', '#status_btn_ina', function () {

    var id = $(this).closest('tr').find('td').eq(1).text();
    var status = '1'
    $.ajax({
        type: "post",
        url: "foodmastercontroller.php",
        data: {
            'id': id,
            'status': status,
            'req_type': 'updatestatus'
        },
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.status == 1) {

                //  alert(response.message)


            }

            getfoodatalist();
        }
    });



})




$(document).on('click', '#create_new', function(){
      $('#formmodal').modal('show');
})


function imageinmodak(image){


    console.log(image);
var image =  $('<img>').attr('src', 'image/'+image+'').addClass('imagesizemodal'); 

    $('#imagbody').empty().append(image);

    $('#imagemodal').modal('show');
}