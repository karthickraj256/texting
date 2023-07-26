<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Student Registered</h2>  
  <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="float : right">Register</button>
<br>


  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="datas">
      <!-- <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
        <td>john@example.com</td>
        <td>john@example.com</td>
        <td><div class="btn-group">
  <button type="button" class="btn btn-primary">Edit</button>
  <button type="button" class="btn btn-danger">Delete</button>
</div></td>
      </tr> -->
    </tbody>
  </table>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
      <form class="form-horizontal" id="form_submit">
        @csrf
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Registered</h4>
        <input type="hidden" name="id" id="id">
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
          <ul class="error-list">
            
          </ul>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="fname">Name:</label>
            <div class="col-sm-5">
            <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname">
            </div>
            <div class="col-sm-5">
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="phone">Phone No:</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone No">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="address">Address:</label>
            <div class="col-sm-10">
            <textarea class="form-control" id="address" placeholder="Enter Address" name="address"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>
</form>

  </div>
</div>       
</body>

<script>
  $(".alert-danger").hide();
    $("form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('register') }}",
            data: $(this).serialize(),
            type: 'POST',
            success: (data) => {
              $(".alert-danger").hide();
                console.log(data);
                if(data.status){
                    getData();
                    $("#form_submit").trigger("reset");
                    $("#myModal").modal('toggle');
                }
            },
            error: function(jqXHR, exception) {
              var mess = ''
              $(".alert-danger").show();
              var error = jqXHR.responseJSON.errors;
              Object.keys(error).forEach(key => {
                mess += `<li>${error[key]}</li>`;
              });
              console.log(mess);
              $(".error-list").html(mess);
            }
        });
    });

    function getData() {
        var text = ``;
        $.ajax({
            url: "{{ route('getData') }}",
            type: 'get',
            success: (data) => {
                console.log(data);
                data.data.map(e => {
                    text += `<tr>
                        <td>${e.fname}</td>
                        <td>${e.lname}</td>
                        <td>${e.email}</td>
                        <td>${e.phone}</td>
                        <td>${e.address}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" onClick="edited(${e.id})" data-toggle="modal" data-target="#myModal">Edit</button>
                                <button type="button" class="btn btn-danger" onClick="deleted(${e.id})">Delete</button>
                            </div>
                        </td>
                    </tr>`;
                });
                $("#datas").html(text);
            }
        });
    }
    getData();

    function deleted(id) {
        $.ajax({
            url: "{{ route('delete') }}",
            data: "id="+id,
            type: 'get',
            success: (data) => {
                console.log(data);
                if(data.status){
                    getData();
                }
            }
        });
    }

    function edited(id) {
        $.ajax({
            url: "{{ route('edit') }}",
            data: "id="+id,
            type: 'get',
            success: (data) => {
                console.log(data);
                if(data.status){
                    $("#fname").val(data.users.fname);
                    $("#lname").val(data.users.lname);
                    $("#email").val(data.users.email);
                    $("#phone").val(data.users.phone);
                    $("#id").val(data.users.id);
                    $("#address").val(data.users.address);
                }
            }
        });
    }

</script>
</html>
