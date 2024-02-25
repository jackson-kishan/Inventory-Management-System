<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <section type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </section>
                                
                                
                                <label class="form-label">Product Name </label>
                                <input type="text" class="form-control" id="productName">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" id="productPrice">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" id="productUnit">

                                <br>
                                <img class="w-15" id="newImg" src="{{ asset('images/default.jpg') }}" alt="">
                                <br>

                                <label class="form-label">Image</label>
                                <input type="file" oninput="newImg.src=window.URL.createObjectURL(this.files[0])" class="form-control" id="productImg">


                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>



<script>

    FillCreateDropDown();

    async function FillCreateDropDown() {
        let res = await axios.get('/list-category')
      
       
    }

    async function Save() {

        try {
            let productCategory = document.getElementById('productCategory').value;
            let productName = document.getElementById('productName').value;
            let productPrice = document.getElementById('productPrice').value;
            let productUnit = document.getElementById('productUnit').value;
            let productImg = document.getElementById('productImg').files[0];

            if(productCategory.length === 0) {
                errorToast('Product category is required');

            } else if(productName.length === 0) {
                errorToast('Product name is required');

            } else if(productPrice.length === 0) {
                errorToast('Product price is required');

            } else if(productUnit.length === 0) {
                errorToast('Product unit is required');

            } else if(!productImg) {
                errorToast('Product image is required');
            } else {

                document.getElementById('modal-close').click();

                let formData = new FormData();
                formData.append('img', productImg)
                formData.append('name', productName)
                formData.append('price', productPrice)
                formData.append('unit', productUnit)
                formData.append('category_id', productCategory)

                const config = {
                    headers: {
                        'content-type' : 'multipart/form-data'
                    }    
                }

           showLoader();
            let res = await axios.post("/create-product", formData, config);
            hideLoader();

            if(res.status === '201'){
                successToast('Request completed successfully');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast(res.data['message'])
            }
         }     

        } catch (e) {
            unauthorized('Request Failed');
        }

    }

</script>