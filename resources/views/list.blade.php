@extends('layout.app')
@section('title','List Crud')
@section('content')
<h2>Crud List</h2> 
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#ContactAddModal">
  Add Contact
</button><hr>


<table class="table table-bordered">
  <thead>
    <tr>
      <th>Sl</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Mobile No</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="ContactBody">
  </tbody>
</table>



  <!-- The Modal Contact Add -->
  <div class="modal fade" id="ContactAddModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Contact Add</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        
          <div class="row">
          <div class="form-group">
            <div class="col-sm-6">
              <input type="text" class="form-control"  placeholder="First Name" id="Firstname">

            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control"  placeholder="Last Name" id="Lastname" >
            </div>
          </div>
          <br>
          <br>
          </div>
          <div class="row">
          <div class="form-group">
            <div class="col-sm-6">
              <input type="text" class="form-control"  placeholder="Mobile No" id="Mobilenumber" >
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control"  placeholder="Email" id="Email">
            </div>
          </div>
          </div>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
          <button  id="ContactAddConfirmBtn" type="button" class="btn  btn-sm  btn-success">Submit</button>
</div>
        
      </div>
    </div>
  </div>

    <!-- The Modal Contact Update -->
    <div class="modal fade" id="UpdateContactModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Contact Update</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
            <div id="ContactEditId" style="display:none"> </div>
            <div class="row">
            <div class="form-group">
              <div class="col-sm-6">
                <input type="text" class="form-control"  placeholder="First Name" id="Firstnameupdate">
  
              </div>
              <div class="col-sm-6">
                <input type="text" class="form-control"  placeholder="Last Name" id="Lastnameupdate" >
              </div>
            </div>
            <br>
            <br>
            </div>
            <div class="row">
            <div class="form-group">
              <div class="col-sm-6">
                <input type="text" class="form-control"  placeholder="Mobile No" id="Mobilenumberupdate" >
              </div>
              <div class="col-sm-6">
                <input type="text" class="form-control"  placeholder="Email" id="Emailupdate">
              </div>
            </div>
            </div>
  
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
            <button  id="ContactUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-success">Submit</button>
  </div>
          
        </div>
      </div>
    </div>



     <!-- The Modal Contact Delete -->
     <div class="modal fade" id="deleteContactModal">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Contact Delete</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body p-3 text-center">
            <h5 class="mt-4">Do You Want To Delete?</h5>
            <h5 id="ContactDeleteId" style="display:none;">   </h5>
        </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
            <button  id="ContactDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
        </div>
          
        </div>
      </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">

$(document).ready(function() {
	GetContactList();

  });

function GetContactList() {
	axios.get('/list').then(function(response) {
		if(response.status == 200) {
			$('#ContactBody').empty();
			var jsonData = response.data;
      var count = 1;
			$.each(jsonData, function(i, item) {
				$('<tr>').html("<td>" + (count++) + "</td>" + 
                "<td>" + jsonData[i].firstname + "</td>" +
                "<td>" + jsonData[i].lastname +  "</td>" + 
                "<td>" + jsonData[i].email +  "</td>" + 
                "<td>" + jsonData[i].number +  "</td>" + 
                "<td><a  class='btn btn-outline-info btn-sm ContactEditBtn' data-id=" + jsonData[i].id + ">Edit</a> <a class=' btn btn-outline-info btn-sm ContactDeleteBtn' data-id="+jsonData[i].id+">Delete</a> </td>")
                .appendTo('#ContactBody');  
                
                $('.ContactEditBtn').click(function() {
                        var id = $(this).data('id');
                        ContactDetails(id);
                        $('#ContactEditId').html(id);
                        $('#UpdateContactModal').modal('show');
                    })

                    $('.ContactDeleteBtn').click(function(){
                            var id= $(this).data('id');
                            $('#ContactDeleteId').html(id);
                            $('#deleteContactModal').modal('show');
                        })


            });
		}
	}).catch(function(error) {});
}



/***********Contact Add********/
$('#ContactAddConfirmBtn').click(function() {
    var Firstname = $('#Firstname').val();
    var Lastname = $('#Lastname').val();
    var Number = $('#Mobilenumber').val();
    var Email = $('#Email').val();
    ContactAdd(Firstname,Lastname,Number,Email);
})

function ContactAdd(Firstname,Lastname,Number,Email) {
    if (Firstname.length == 0) {
        toastr.error('First name is Empty !');
    }
    else if (Lastname.length == 0) {
        toastr.error('Last name is Empty !');
    } 
    else if (Number.length == 0) {
        toastr.error('Mobile no is Empty !');
    } 
    else if (Email.length == 0) {
        toastr.error('Email is Empty !');
    } else {
        $('#ContactAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/contact-store', {
          Firstname: Firstname,
          Lastname: Lastname,
          Number: Number,
          Email: Email,
            })
            .then(function(response) {
                $('#ContactAddConfirmBtn').html("Save");
                if (response.status == 200) {
                    if (response.data == 1) {
                        $('#ContactAddModal').modal('hide');
                        toastr.success('Contact Added Success');
                        $('#ContactAddModal').on('hidden.bs.modal', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})
GetContactList();

                    } else {
                        $('#ContactAddModal').modal('hide');
                        toastr.error('Contact Added Fail');
                        GetContactList();
                    }
                } else { }

            })
            .catch(function(error) { });
    }
}


function ContactDetails(id) {
    axios.post('/contact-edit', {
            id: id,
        })
        .then(function(response) {
            if (response.status == 200) {
                $('#Firstnameupdate').empty();
                $('#Lastnameupdate').empty();
                $('#Mobilenumberupdate').empty();
                $('#Emailupdate').empty();
                var jsonSingleData = response.data;
                $('#Firstnameupdate').val(jsonSingleData[0].firstname);
                $('#Lastnameupdate').val(jsonSingleData[0].lastname);
                $('#Mobilenumberupdate').val(jsonSingleData[0].number);
                $('#Emailupdate').val(jsonSingleData[0].email);
            } else { }
        })
        .catch(function(error) { });
}


$('#ContactUpdateConfirmBtn').click(function() {
    var ContactId = $('#ContactEditId').html();
    var Firstname = $('#Firstnameupdate').val();
    var Lastname = $('#Lastnameupdate').val();
    var Number = $('#Mobilenumberupdate').val();
    var Email = $('#Emailupdate').val();
    ContactUpdate(ContactId,Firstname,Lastname,Number,Email);
})

function  ContactUpdate(ContactId,Firstname,Lastname,Number,Email) {
  if (Firstname.length == 0) {
        toastr.error('First name is Empty !');
    }
    else if (Lastname.length == 0) {
        toastr.error('Last name is Empty !');
    } 
    else if (Number.length == 0) {
        toastr.error('Mobile no is Empty !');
    } 
    else if (Email.length == 0) {
        toastr.error('Email is Empty !');
    } else {
        $('#ContactUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/ContactUpdate', {
            ContactId: ContactId,
            Firstname: Firstname,
          Lastname: Lastname,
          Number: Number,
          Email: Email,
            })
            .then(function(response) {
                $('#ContactUpdateConfirmBtn').html("Save");
                if (response.status == 200) {
                    if (response.data == 1) {
                        $('#UpdateContactModal').modal('hide');
                        toastr.success('Contact  Update Success');
                        GetContactList();
                    } else {
                        $('#UpdateContactModal').modal('hide');
                        toastr.error('Contact  Update Fail');
                        GetContactList();
                    }
                } else { }
            })
            .catch(function(error) { });
    }
}

 // Contact Delete Confirm
 $('#ContactDeleteConfirmBtn').click(function(){
            var id= $('#ContactDeleteId').html();
            ContactDelete(id);
        })
        // Contact Delete
        function ContactDelete(deleteID) {
            $('#ContactDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
            axios.post('/ContactDelete', {
                id: deleteID
            })
                .then(function(response) {
                    $('#ContactDeleteConfirmBtn').html("Yes");
                    if(response.status==200){
                        if (response.data == 1) {
                            $('#deleteContactModal').modal('hide');
                            toastr.success('Delete Success');
                            GetContactList();
                        } else {
                            $('#deleteContactModal').modal('hide');
                            toastr.error('Delete Fail');
                            GetContactList();
                        }
                    }
                    else{ }
                })
                .catch(function(error) {  });
        }



            </script>
@endsection