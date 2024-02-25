@extends('layout.sidenav-layout')

@section('content')

      <div class="container-fluid">
         <div class="row">
            <div class="col-md-4 col-lg-4 p2">
                <div class="shadow-sm h-100 bg-white rounded-3 p3">
                    <div class="row">
                        <div class="col-8">
                            <span class="text-bold text-dark">BILLED TO </span>
                            <p class="text-xs mx-0 my-1">Name: <span id="CName"></span></p>
                            <p class="text-xs mx-0 my-1">Email: <span id="CEmail"></span></p>
                            <p class="text-xs mx-0 my-1">User ID: <span id="CId"></span></p>
                        </div>
                        <div class="col-4">
                            <img src="{{ "images/>logo.png" }}" alt="" class="w-40">
                            <p class="text-bold mx-0 my-1 text-dark">Invoice</p>
                            <p class="text-xs mx-0 my-1">Date: {{ date("Y-m-d") }}</p>
                        </div>
                    </div>

                    <hr class="mx-0 my-2 p-0 bg-secondary">

                    <div class="row"></div>

                </div>
            </div>

            <div class="col-md-4 col-lg-4 p2">
                <div class="shadow-sm h-100 bg-white rounded-3 p3">
                    <table class="table table-sm w-100" id="productTable">
                        <thead class="w-100">
                            <tr class="text-xs">
                                <td>Product</td>
                                <td>Pick</td>
                            </tr>
                        </thead>
                        <tbody class="w-100" id="productList">

                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-4 col-lg-4 p2">
                <div class="shadow-sm h-100 bg-white rounded-3 p3">
                    <table class="table table-sm w-100" id="customerTable">
                        <thead class="w-100">
                            <tr class="text-xs">
                                <td>Customer</td>
                                <td>Pick</td>
                            </tr>
                        </thead>
                        <tbody class="w-100" id="customerList">

                        </tbody>
                    </table>
                </div>
            </div>

         </div>
      </div>

      <div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Add Product</h6>
                </div>

                <div class="modal-body">
                    <form action="" id="add-form">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 p1">
                                    <label for="" class="form-label">Product ID *</label>
                                    <input type="text" class="form-control" id="PId">
                                    <label for="" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" id="PName">
                                    <label for="" class="form-label">Product Price *</label>
                                    <input type="text" class="form-control" id="PPrice">
                                    <label for="" class="form-label">Product Qty *</label>
                                    <input type="text" class="form-control" id="PQty">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                  <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" id="modal-close" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button class="btn btn-sm btn-success" id="save-btn">Add</button>
                  </div>
            </div>
         </div>
      </div>





      <script>

         (async ()=>{
             showLoader();
             await CustomerList();
             await ProductList();
             hideLoader();
         })()


        function addModal(id, name, price) {
            document.getElementById('PId').value = id;
            document.getElementById('PName').value = name;
            document.getElementById('PPrice').value = price;
            $('#create-modal').modal('show');
        }


       async function CustomerList() {
        let res = await axios.get('/list-customer');
        let customerList = $('#customerList');
        let customerTable = $('#customerTable');
        customerTable.DataTable().destroy();
        customerList.empty();

        res.data.forEach(function (item, index) {
            let row = ` <tr class="text-xs">
                         <td><i class="bi bi-person"> ${item['name']} </i></td>
                         <td><a data-name="${item['name']}" data-email="${item['email']}" data-id="${item['id']}" class="btn btn-outline-dark addCustomer text-xxs px-2 py-1 btn-sm m-0"> ADD </a></td>
                     </tr>`  
              customerList.append(row);       
        })

        $('.addCustomer').on('click', async function () {
            let CName = $(this).data('name');
            let CEmail = $(this).data('email'); 
            let CId = $(this).data('id');

            $('#CName').text(CName);
            $('#CEmail').text(CEmail);
            $('#CId').text(CId);
        });

        new DataTable('#customerTable', {
           order: [0 , 'desc'],
           scrollCollapse: false,
           info : false,
           lengthChanged : false, 
        })


       }

       async function ProductList() {

        let res = await axios.get("/list-product");
        let productList = ${'#productList'};
        let productTable = ${'#productTable'};
        productTable.DataTable().destroy();
        productList.empty();

        res.data.forEach( (item, index) => {
          let row = `<tr class="text-xs">
                   <td><img class="w-10" src="${item['img_url']}"> ${item['name']} (${item['price']})</td>
                   <td> <a data-name="${item['name']}" data-price="${item['price']}" data-id="${item['id']}" class="btn btn-outline-dark addProduct text-xxs px-2 py-1 btn-sm m-0"> ADD </a></td>
                    </tr>`
                    productList.append(row);
        });

        $('.addProduct').on('click', async function () {
            let PName = $(this).data('name');
            let PPrice = $(this).data('price');
            let PId = $(this).data('id');

            addMoal(PId, PName, PPrice)
        });

        new DataTable('#productTable', {
           order: [0 , 'desc'],
           scrollCollapse: false,
           info : false,
           lengthChanged : false, 
        }) 

       }

      </script>

@endsection