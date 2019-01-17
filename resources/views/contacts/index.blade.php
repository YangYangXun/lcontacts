@extends('contacts.master')
@section('content')
<div class="container">

    <div class="row">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#exampleModal" id="add-item-btn">
            Add Item
        </button>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Function</th>
                </tr>
            </thead>
            <tbody id="data-panel">

            </tbody>
        </table>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Contact</h5>
                </div>
                <div class="modal-body">
                    <form action="">
                        <input type="hidden" id="contact-id" name="id">
                        <div class="form-group">
                            <label for="name"> Name : </label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"> Phone : </label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn-add" data-dismiss="modal">Add</button>
                    <button type="button" class="btn btn-primary" id="btn-update" data-dismiss="modal" style="display:none;">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/app.js') }}"></script>

<script>
    // Get Variable for use
    var form_title = document.getElementById('exampleModalLabel')

    function getData(){

    }

    // Get all data from api
    axios.get('http://localhost/lcontacts/public/api/contacts', {
    })
    .then(function (response) {
        const data = response.data.data
        // Add data to data panel
        var content = ''
        for (let i = 0; i < data.length; i++) {
            content += '<tr>'
            content += '<th scope="row">' + data[i].id + '</th>'
            content += '<td>' + data[i].name + '</td>'
            content += '<td>' + data[i].phone + '</td>'
            content += '<td><button type="button" class="btn btn-outline-primary mr-2 btn-edit" data-toggle="modal" data-target="#exampleModal" id="' + data[i].id + '">Edit</button>'
            content += '<button type="button" class="btn btn-outline-secondary btn-delete" id="' + data[i].id + '">Delete</button></td>'
            content += '</tr>'
        }
        document.getElementById('data-panel').innerHTML = content
    })
    .catch(function (error) {
        console.log(error);
    });
    //Button Setting
    document.getElementById('add-item-btn').addEventListener('click', function(){
        var name = document.getElementById('name')
        var phone = document.getElementById('phone')
        name.value = ''
        phone.value = ''
        // Reset the form title
        form_title.innerText = "Add Contact"
    })
    /* Function Insert */
    document.getElementById('btn-add').addEventListener('click', function () {
        var name = document.getElementById('name')
        var phone = document.getElementById('phone')
        axios.post(`http://localhost/lcontacts/public/api/contact`, {
           name: name.value ,
           phone: phone.value
        })
        .then(function (response) {
            console.log(response)
            location.reload()
        })
        .catch(function (error) {
            console.log(error);
        });
    })
    /* Function Update */
    var btn_update = document.getElementById('btn-update')
    btn_update.addEventListener('click',function () {
        var id = document.getElementById('contact-id').value
        var name = document.getElementById('name')
        var phone = document.getElementById('phone')
        axios.patch(`http://localhost/lcontacts/public/api/contact/${id}`, {
           name: name.value ,
           phone: phone.value
        })
        .then(function (response) {
            console.log(response)
            location.reload()
        })
        .catch(function (error) {
            console.log(error);
        });
    })

    window.onload = function () {
        /* Function Edit */
        // Add EventListener to each edit btn
        var edit_btns = document.querySelectorAll('.btn-edit')
        Array.from(edit_btns).forEach(function (btn) {
            const id = btn.getAttribute('id')
            btn.addEventListener('click',function () {
                // Show update button, Hide add button
                var btn_add = document.getElementById('btn-add')
                var btn_update = document.getElementById('btn-update')
                btn_add.style.display = "none"
                btn_update.style.display = "block"

                // Reset the form title
                form_title.innerText = "Edit Contact"
                axios.get(`http://localhost/lcontacts/public/api/contact/${id}`, {
                })
                .then(function (response) {
                    var id = document.getElementById('contact-id')
                    var name = document.getElementById('name')
                    var phone = document.getElementById('phone')
                    var data = response.data.data
                    id.value = data.id
                    name.value = data.name
                    phone.value = data.phone
                })
                .catch(function (error) {
                    console.log(error);
                });
            })
        })


        /* Function Delete */
        // Add EventListener to each delete btn
        var delete_btns = document.querySelectorAll('.btn-delete')
        Array.from(delete_btns).forEach(function (btn) {
            btn.addEventListener('click',function () {
                var id = btn.getAttribute('id')

                axios.delete(`http://localhost/lcontacts/public/api/contact/${id}`, {
                })
                .then(function (response) {
                    console.log(response)
                    location.reload();
                })
                .catch(function (error) {
                    // console.log(name.value);
                    // console.log(phone.value);
                    console.log(error);
                });
            })
        })

    }

</script>
@endsection
