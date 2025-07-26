<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-add"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-add">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="addEmployeeForm">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default-employeeName">Employee Name</span>
                        </div>
                        <input type="text" class="form-control col-xs-3" required id="employee_name"
                               name="employee_name" aria-label="Sizing example input"
                               aria-describedby="inputGroup-sizing-default-employeeName" autocomplete="off">
                    </div>

                    <select required id="departmentName" style="width: 100%;" name="departmentName"
                            class="custom-select form-control">
                        <option disabled value="0" selected>Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->department_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addEmployeeBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
