@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1 class="title">Employees Data</h1>
        </div>
        <div class="col-md-6">
            <button onclick="document.querySelector('[name=id]').value = ''" data-toggle="modal" data-target="#addEmployeeModal" class="btn btn-primary btn-lg float-right">Add Employee</button>
            <a href="/export-employees">
                <button type="button" class="btn btn-outline-danger btn-lg float-right mr-2">Export PDF</button>
            </a>
            <button type="button" onclick="document.getElementById('excel').click()" class="btn btn-outline-success btn-lg float-right mr-2">Import Excel</button>
            <input type="file" style="display:none" name="importExcel" id="excel">
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Company</th>
                        <th scope="col">Email</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="employee-table">
                    <!-- render by js fetch request -->
                </tbody>
                <div class="pagination float-right justify-content-end">
                    <button class="btn btn-outline-primary btn-sm prev" onclick="paginate('prev')">&lt;&lt;</button>
                    <input type="number" id="current-page" class="form-control col-lg-3 text-center" value="1" readonly>
                    <button class="btn btn-outline-primary btn-sm next" onclick="paginate('next')">&gt;&gt;</button>
                </div>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Employee Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="employee-form">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Name</span>
                            </div>
                            <input type="text" onfocus="this.classList.remove('input-danger')" class="form-control" name="name" value="{{ old('name') }}" placeholder="Company Name" autocomplete="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email</span>
                            </div>
                            <input type="text" onfocus="this.classList.remove('input-danger')" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Company</span>
                            </div>
                            <select onchange="this.classList.remove('input-danger')" name="company" class="form-control" required>
                                <option holder>Select Company</option>
                                @forelse($companies as $company)
                                <option value="{{ $company->name }}">{{ $company->name }}</option>
                                @empty
                                No Company Found !
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    // Fetch data when entering page
    getData()

    const addForm = document.getElementById('employee-form')
    const excelFileInput = document.getElementById('excel')

    // Handle submit form
    addForm.onsubmit = async function(e) {
        e.preventDefault()
        const data = new FormData(addForm)
        const response = await sendRequest('/employees', 'POST', data)

        if (response.status == 'updated') {
            alert('employee updated successfully')
            resetForm()
            getData()
        } else {
            const errors = []

            response.errorInfo.name ? errors.push('name') : null
            response.errorInfo.email ? errors.push('email') : null
            response.errorInfo.company ? errors.push('company') : null

            errors.forEach(error => {
                document.querySelector(`[name="${error}"]`).classList.add('input-danger')
            })

            alert('mohon cek form anda')
        }
    }

    // Handle excel import 
    excelFileInput.onchange = async function() {
        let data = new FormData()
        data.append('importExcel', excelFileInput.files[0])

        const response = await sendRequest('/employees/import-excel', 'POST', data)

        if (response.status == 'imported') {
            alert('data berhasil diimport')
            getData()

            document.querySelector('.next').removeAttribute('disabled')
        } else alert('error happened')
    }

    // Reset form when close modal
    document.querySelector('#addEmployeeModal .close').onclick = function() {
        resetForm()
    }

    // Handle paginate behavior
    async function paginate(direction) {
        const nextButton = document.querySelector('.next')
        let currentPagination = parseInt(document.getElementById('current-page').value)

        nextButton.removeAttribute('disabled')
        if (direction == 'next') {
            document.getElementById('current-page').value = currentPagination + 1
            await getData(`/get-employees?page=${currentPagination + 1}`)

            const nextCheck = await sendRequest(`/get-employees?page=${currentPagination + 2}`)
            if (nextCheck.results.data.length === 0) {
                nextButton.setAttribute('disabled', true)
            }

        } else {
            document.getElementById('current-page').value = currentPagination - 1
            await getData(`/get-employees?page=${currentPagination - 1}`)
        }
    }

    // Fetch employees data and render into table
    async function getData(url = '/get-employees?page=1') {
        loader('show')
        const response = await sendRequest(url, 'GET')
        const page = url.split('page=')[1]
        const pattern = (page - 1) * 5

        const element = response.results.data.reduce((elem, data, index) => {
            elem += `<tr>
                        <td>${page == 1 ? index + 1 : index + 1 + pattern}</td>
                        <td>${data.name}</td>
                        <td>${data.company}</td>
                        <td>${data.email}</td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#addEmployeeModal" onclick="editEmployee(${data.id})" class="btn btn-warning btn-sm">Edit</button>
                            <button type="button" onclick="if (confirm('are you sure')) {deleteEmployee(${data.id})}" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>`

            return elem
        }, "")

        if (url == '/get-employees?page=1') {
            document.querySelector('.prev').setAttribute('disabled', true)
        } else document.querySelector('.prev').removeAttribute('disabled')

        loader('hide')

        if (response.results.data.length === 0) {
            document.getElementById('employee-table').innerHTML = '<h3>NO DATA</h3>'
            document.querySelector('.next').setAttribute('disabled', true)
            return
        }

        document.getElementById('employee-table').innerHTML = element
    }

    // Get employee details and append to form value
    async function editEmployee(id) {
        const response = await sendRequest(`/get-employee/${id}`, 'GET')

        document.querySelector('[name="id"]').value = response.results.id
        document.querySelector('[name="name"]').value = response.results.name
        document.querySelector('[name="email"]').value = response.results.email
        document.querySelector('[name="company"]').value = response.results.company
    }

    // Handle employee delete
    async function deleteEmployee(id) {
        const response = await sendRequest(`/employee/${id}`, 'DELETE')
        if (response.status == 'deleted') {
            alert('berhasil dihapus')
            getData()
        }
    }

    // Handle http request
    async function sendRequest(url, type, content = null) {
        const data = await fetch(url, {
            method: type,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
            },
            body: content,
        }).catch(err => {
            console.error(err)
        })

        return data.json();
    }

    // Handle table data loader
    function loader(condition) {
        if (condition == 'show') {
            const loader = `<img style="position:absolute;margin: 4% 36%" class="table-loader" src="/images/table-loader.gif">`
            document.getElementById('employee-table').innerHTML = loader
        } else document.querySelector('img.table-loader').remove()
    }

    // Handle form reset
    function resetForm() {
        addForm.reset()
        document.querySelector('[name="id"]').value = ""
    }
</script>
@endsection