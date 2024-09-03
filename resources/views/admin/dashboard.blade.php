
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Admin Dashboard</title>
      <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
      <link href="https://cdn.datatables.net/v/bs5/dt-2.1.4/datatables.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
      <style>
      /* Style even columns */
      table.dataTable thead th:nth-child(n) {
        background-color: #697565; /* Replace with your desired color */
        color:#ffffff;
 /* Replace with your desired text color */
}
table.dataTable tbody td:nth-child(even) {
  background-color: #ECDFCC; /* Light cyan color for even columns */
}

/* Style odd columns */
table.dataTable tbody td:nth-child(odd) {
    background-color: #ECDFCC; /* Light yellow color for odd columns */
}
table.dataTable tbody td {
            border: 1px solid #ffff; /* Example border color */
        }

      </style>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if there are validation errors or session flash data to open the modal
            @if ($errors->any())
                var myModal = new bootstrap.Modal(document.getElementById('addProductModal'));
                myModal.show();
            @endif
            $('#addProductModal').on('hidden.bs.modal', function () {
    // Code to execute after the modal is hidden
    $(this).find('input').removeClass('is-invalid'); // Remove invalid classes
    $(this).find('.invalid-feedback').remove(); // Clear error messages
    $(this).find('form')[0].reset(); // Reset the form inside the modal
    $('#preview_img').html('');
    $("#add_product_btn").text(' Add product')
    });
});
    </script>
    </head>
   <body class="bg-light">
       <!-- Modal class starts-->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add new Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form id="add_products_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="my-2">
                            <label for="Pname">Product Name</label>
                            <input type="text" name="Pname" id="Pname" class="form-control @error('Pname') is-invalid @enderror" placeholder="Enter Product Name">
                            @error('Pname')
                                <p class="invalid-feedback">{{$message}}</p>
                             @enderror
                        </div>
                        <div class="my-2">
                            <label for="Pdesc">Product Description</label>
                            <input type="text" name="Pdesc" id="Pdesc" class="form-control  @error('Pdesc') is-invalid @enderror" placeholder="Enter Product Description">
                            @error('Pdesc')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="Pprice">Price</label>
                            <input type="text" name="Pprice" id="Pprice" class="form-control  @error('Pprice') is-invalid @enderror" placeholder="Enter Product Price">
                            @error('Pprice')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="Pqty">Quantity</label>
                            <input type="text" name="Pqty" id="Pqty" class="form-control  @error('Pqty') is-invalid @enderror" placeholder="Enter Product Quantity">
                            @error('Pqty')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="Pweight">Weight</label>
                            <input type="text" name="Pweight" id="Pweight" class="form-control  @error('Pweight') is-invalid @enderror" placeholder="Enter Product Weight">
                            @error('Pweight')
                                     <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="Pdimen">Dimensions</label>
                            <input type="text" name="Pdimen" id="Pdimen" class="form-control  @error('Pdimen') is-invalid @enderror" placeholder="Enter Product Dimensions">
                            @error('Pdimen')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="Pimg">image_url</label>
                            <input type="file" name="Pimg"  id="Pimg" class="form-control  @error('Pimg') is-invalid @enderror">
                            @error('Pimg')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="status">status</label>
                            <input type="text" name="status" id="status" class="form-control  @error('status') is-invalid @enderror" placeholder="Enter Product description">
                            @error('status')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2" id="preview_img">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                        <button type="submit" class="btn btn-primary" id="add_product_btn">Add product</button>
                    </div>
                </form>
            </div>
        </div>
   </div>
   {{-- edit employee modal start --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_product_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="edit_pro_id" id="edit_pro_id">
        <input type="hidden" name="edit_pro_img" id="edit_pro_img">
        <div class="modal-body p-4 bg-light">
             <div class="my-2">
                <label for="Pname">Product Name</label>
                    <input type="text" name="edit_Pname" id="edit_Pname" class="form-control" placeholder="Enter Product Name">
            </div>
            <div class="my-2">
                <label for="Pdesc">Product Description</label>
                    <input type="text" name="edit_Pdesc" id="edit_Pdesc" class="form-control " placeholder="Enter Product Description">
                       
            </div>
            <div class="my-2">
                <label for="Pprice">Price</label>
                    <input type="text" name="edit_Pprice" id="edit_Pprice" class="form-control" placeholder="Enter Product Price">
                        
            </div>
            <div class="my-2">
                <label for="Pqty">Quantity</label>
                    <input type="text" name="edit_Pqty" id="edit_Pqty" class="form-control " placeholder="Enter Product Quantity">
                        
            </div>
            <div class="my-2">
                <label for="Pweight">Weight</label>
                    <input type="text" name="edit_Pweight" id="edit_Pweight" class="form-control " placeholder="Enter Product Weight">
                      
            </div>
            <div class="my-2">
                <label for="Pdimen">Dimensions</label>
                        <input type="text" name="edit_Pdimen" id="edit_Pdimen" class="form-control " placeholder="Enter Product Dimensions">
                           
            </div>
            <div class="my-2">
                <label for="Pimg">image_url</label>
                        <input type="file" name="edit_Pimg"  class="form-control">
                          
            </div>
            <div class="my-2">
                <label for="status">status</label>
                       <input type="text" name="edit_status" id="edit_status" class="form-control " placeholder="Enter Product description">
                         
            </div>
            <div class="mt-2" id="edit_Pimg">

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_product_btn" class="btn btn-success">Update Products</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}
   <!-- Modal class ends-->
    <nav class="navbar navbar-expand-md  shadow-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret"  style="background-color:#1E201E">
            <div class="container"  >
                <a class="navbar-brand" href="#" style="color:#ffff">
                   <strong>Admin Dashboard</strong>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffff">Hello, {{Auth::guard('admin')->user()->name}}</a>
                            <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">                          
                                <li>
                                    <a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </nav>
       <div class="container bg-light">
            <div class="row my-5">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between" style="background-color:#3C3D37">
                            <h3 class="text-light">Manage Products</h3>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi-plus-circle me-2"></i>Add New Products</button>
                        </div>
                        <div class="card-body" id="show-all-products">
                            <h1 class="text-center text-secondary my-5">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
       </div>

     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
       <script>
     $(function() {
        
    // Debugging: Check if jQuery is loaded and function is called
    // Add new employee AJAX request
    
     $(document).on('change', 'input[name="Pimg"]', function() {
            let fileInput = this;
            if (fileInput.files && fileInput.files[0]) {
               var imageUrl = URL.createObjectURL(fileInput.files[0]);
               $('#preview_img').html('<img src="' + imageUrl + '" width="100" class="img-fluid img-thumbnail">');
             }
          });
    $("#add_products_form").submit(function(e) {
        e.preventDefault();
       $("#add_product_btn").text('Adding...')
        const fd = new FormData(this);

        $("#add_product_btn").text('Adding...').prop('disabled', false); // Disable button to prevent multiple submissions
        
        $.ajax({
            url: '/admin/store', // Ensure this is the correct URL
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Product Added Successfully!',
                'success'
              )
              fetchAllProducts(); 
            }
            $("#add_products_form")[0].reset();
            $("#addProductModal").modal('hide');
            $('#preview_img').html('');
          }
        });
    });
    fetchAllProducts(); 

    // edit employee ajax request
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '/admin/edit',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#edit_Pname").val(response.Product_name);
            $("#edit_Pdesc").val(response.Description);
            $("#edit_Pprice").val(response.price);
            $("#edit_Pqty").val(response.quantity);
            $("#edit_Pweight").val(response.weight);
            $("#edit_Pdimen").val(response.dimensions);
            $("#edit_status").val(response.status);
            $("#edit_Pimg").html(
              `<img src="/storage/images/${response.image_url}" width="100" class="img-fluid img-thumbnail">`);
            $("#edit_pro_id").val(response.id);
            $("#edit_pro_img").val(response.image_url);
            }
        });
        $(document).on('change', 'input[name="edit_Pimg"]', function() {
            let fileInput = this;
            if (fileInput.files && fileInput.files[0]) {
               var imageUrl = URL.createObjectURL(fileInput.files[0]);
               $('#edit_Pimg').html('<img src="' + imageUrl + '" width="100" class="img-fluid img-thumbnail">');
             }
          });
      });
      // update employee ajax request
      $("#edit_product_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_product_btn").text('Updating...');
        $.ajax({
          url: '/admin/update',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'product Updated Successfully!',
                'success'
              )
              fetchAllProducts();
            }
            $("#edit_product_btn").text('Update Products');
            $("#edit_product_form")[0].reset();
            $("#editProductModal").modal('hide');
          }
        });
      });
      // delete employee ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '/admin/delete',
              method: 'post',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllProducts();
              }
            });
          }
        })
      });
    function fetchAllProducts() {
        $.ajax({
          url: '{{ route('fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show-all-products").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
});
       

      </script>
     <!-- imported files-->
    
     <script src="https://cdn.datatables.net/v/dt/dt-2.1.4/datatables.min.js"></script>   
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <!-- imported files ends-->
  </body>
</html>